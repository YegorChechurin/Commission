<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\CommissionsManager;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;

class CommissionFeeCalculator
{
	/** 
	 * @var CommissionsManager 
	 */
	private $cm;

	private $currencyConverter;

	private $rounder;

	private $naturalCashOutHistrory;

	public function __construct(CommissionsManager $cm, CurrencyConverterInterface $currencyConverter, CommissionFeeRounder $rounder)
	{
		$this->cm = $cm;

		$this->currencyConverter = $currencyConverter;

		$this->rounder = $rounder;

		$this->naturalCashOutHistrory = [];
	}

	public function calculateCommissionFee(array $operationParams): ?string
	{
		$fee = null;

		if ($operationParams['name'] === 'cash_in') {
			$fee = $this->calculateCashInCommissionFee($operationParams);
		} elseif ($operationParams['name'] === 'cash_out' && $operationParams['user_type'] === 'legal') {
			$fee = $this->calculateLegalCashOutCommissionFee($operationParams);
		} else {
			$fee = $this->calculateNaturalCashOutCommissionFee($operationParams);
		}

		return $fee;
	}

	public function calculateCashInCommissionFee(array $operationParams): string
	{
		$commissionParams = $this->cm->getCommissionParameters($operationParams['name']);

		$fee = $commissionParams['fee'] * $operationParams['amount'];

		if ('EUR' !== $operationParams['currency']) {
			$feeInEUR = $this->currencyConverter->convertToEuro($operationParams['currency'], $fee);

			if ($feeInEUR > $commissionParams['maximum_amount']) {
			    $feeInEUR = $commissionParams['maximum_amount'];
		    } 

		    $fee = $this->currencyConverter->convertFromEuro($operationParams['currency'], $feeInEUR);
		} else {
			if ($fee > $commissionParams['maximum_amount']) {
			    $fee = $commissionParams['maximum_amount'];
		    } 
		}

		return $this->rounder->round($operationParams['currency'], $fee);
	}

	public function calculateLegalCashOutCommissionFee(array $operationParams): string
	{
		$commissionParams = $this->cm->getCommissionParameters($operationParams['name']);

		$fee = $commissionParams['legal']['fee'] * $operationParams['amount'];

		if ('EUR' !== $operationParams['currency']) {
			$feeInEUR = $this->currencyConverter->convertToEuro($operationParams['currency'], $fee);

			if ($feeInEUR < $commissionParams['minimum_amount']) {
			    $feeInEUR = $commissionParams['minimum_amount'];
		    } 

		    $fee = $this->currencyConverter->convertFromEuro($operationParams['currency'], $feeInEUR);
		} else {
			if ($fee < $commissionParams['minimum_amount']) {
			    $fee = $commissionParams['minimum_amount'];
		    } 
		}

		return $this->rounder->round($operationParams['currency'], $fee);
	}

	public function calculateNaturalCashOutCommissionFee(array $operationParams): string
	{
		$commissionParams = $this->cm->getCommissionParameters($operationParams['name']);

		$userId = $operationParams['user_id'];
		$date = $operationParams['date'];
		$operationAmountEUR = $operationParams['amount'];

		if ('EUR' !== $operationParams['currency']) {
			$operationAmountEUR = $this->currencyConverter->convertToEuro($operationParams['currency'], $operationAmountEUR);
		} 

		if (array_key_exists($userId, $this->naturalCashOutHistrory)) {
			$this->updateHistoryRecord($userId, $date, $operationAmountEUR);
		} else {
			$this->createHistoryRecord($userId, $date, $operationAmountEUR);
		}

		$userHistory = $this->naturalCashOutHistrory[$userId];

		if ($userHistory['operation_count'] > $commissionParams['natural']['free_of_charge']['number_of_operations']) {
			$feeInEUR = $commissionParams['natural']['fee'] * $operationAmountEUR;
		} else {
			$feeInEUR = $this->calculateNaturalCashOutCommissionFeeInEuroWithDiscount($commissionParams, $userHistory, $operationAmountEUR);
		}

		if ('EUR' !== $operationParams['currency']) {
			$fee = $this->currencyConverter->convertFromEuro($operationParams['currency'], $feeInEUR); 
		} else {
			$fee = $feeInEUR;
		}
/*var_dump($fee);
var_dump($this->rounder->round($operationParams['currency'], $fee));*/
		return $this->rounder->round($operationParams['currency'], $fee);
	}

	private function updateHistoryRecord(string $userId, string $date, string $operationAmountEUR)
	{
		if (!$this->checkDatesAreOnSameWeek($date, $this->naturalCashOutHistrory[$userId]['date'])) {
			$this->createHistoryRecord($userId, $date, $operationAmountEUR);
		} else {
			$this->naturalCashOutHistrory[$userId]['operation_count']++;
			$this->naturalCashOutHistrory[$userId]['total_amount_in_euro'] += $operationAmountEUR;
			$this->naturalCashOutHistrory[$userId]['date'] = $date;
		}
	}

	private function checkDatesAreOnSameWeek(string $firstDate, string $secondDate): bool
	{
		$onSameWeek = true;

		$year1 = date('o', strtotime($firstDate));
		$year2 = date('o', strtotime($secondDate));

		if ($year1 !== $year2) {
			$onSameWeek = false;
		} else {
			$week1 = date('W', strtotime($firstDate));
			$week2 = date('W', strtotime($secondDate));

			if ($week1 !== $week2) {
				$onSameWeek = false;
			}
		}

		return $onSameWeek;
	}

	private function createHistoryRecord(string $userId, string $date, string $operationAmountEUR)
	{
		$this->naturalCashOutHistrory[$userId] = [
				'operation_count' => 1,
				'date' => $date,
				'total_amount_in_euro' => $operationAmountEUR,
			];
	}

	private function calculateNaturalCashOutCommissionFeeInEuroWithDiscount(array $commissionParams, array $userHistory, string $operationAmountEUR): string
	{
		$feeInEUR = '0.00';

		$freeOfChargeAmount = $commissionParams['natural']['free_of_charge']['amount'];

		if ($userHistory['total_amount_in_euro'] - $operationAmountEUR > $freeOfChargeAmount) {
			$feeInEUR = $commissionParams['natural']['fee'] * $operationAmountEUR;
		} else {
			if ($userHistory['total_amount_in_euro'] > $freeOfChargeAmount) {
				$feeInEUR = $commissionParams['natural']['fee'] * ($userHistory['total_amount_in_euro'] - $freeOfChargeAmount);
			}
		}

		return $feeInEUR;
	}
}
