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

	public function calculateCashInCommissionFee(array $operationParams): array
	{
		$commissionParams = $this->cm->getCommissionParameters($operationParams['name']);

		$fee = $commissionParams['fee'] * $operationParams['amount'];

		if ('EUR' !== $operationParams['name']) {
			$feeInEUR = $this->currencyConverter->convertToEuro($operationParams['currency'], $fee);

			if ($feeInEUR > $commissionParams['maximum_amount']) {
			    $feeInEUR = $commissionParams['maximum_amount'];
		    } 

		    $fee = $this->currencyConverter->convertFromEuro($cashInCurrency, $feeInEUR);
		} else {
			if ($fee > $commissionParams['maximum_amount']) {
			    $fee = $commissionParams['maximum_amount'];
		    } 
		}

		return $this->rounder->round($operationParams['currency'], $fee);
	}

	public function calculateLegalCashOutCommissionFee(array $operationParams): array
	{
		$commissionParams = $this->cm->getCommissionParameters($operationParams['name']);

		$fee = $commissionParams['fee'] * $operationParams['amount'];

		if ('EUR' !== $operationParams['name']) {
			$feeInEUR = $this->currencyConverter->convertToEuro($operationParams['currency'], $fee);

			if ($feeInEUR < $commissionParams['minimum_amount']) {
			    $feeInEUR = $commissionParams['minimum_amount'];
		    } 

		    $fee = $this->currencyConverter->convertFromEuro($cashInCurrency, $feeInEUR);
		} else {
			if ($fee < $commissionParams['minimum_amount']) {
			    $fee = $commissionParams['minimum_amount'];
		    } 
		}

		return $this->rounder->round($operationParams['currency'], $fee);
	}

	public function calculateNaturalCashOutCommissionFee(array $operationParams): array
	{
		$commissionParams = $this->cm->getCommissionParameters($operationParams['name']);

		$weekday = $this->turnDateIntoWeekDay($operationParams['date']);

		if (array_key_exists($operationParams['user_id'], $this->naturalCashOutHistrory)) {
			# do calculations
			# $this->updateHistoryRecord
		} else {
			# do calculations
			# this->createHistoryRecord
		}
	}

	private function updateHistoryRecord(string $userId, string $weekday, string $operationAmountEUR)
	{
		if ('Sunday' === $this->naturalCashOutHistrory[$userId]['weekday'] && 'Monday' === $weekday) {
			$this->createHistoryRecord($userId, $weekday, $operationAmountEUR);
		} else {
			$this->naturalCashOutHistrory[$userId]['operation_count']++;
			$this->naturalCashOutHistrory[$userId]['total_amount_in_euro'] += $operationAmountEUR;
			$this->naturalCashOutHistrory[$userId]['weekday'] = $weekday;
		}
	}

	private function createHistoryRecord(string $userId, string $weekday, string $operationAmountEUR)
	{
		$this->naturalCashOutHistrory[$userId] = [
				'operation_count' => 1,
				'weekday' => $weekday,
				'total_amount_in_euro' => $operationAmountEUR,
			];
	}

	private function turnDateIntoWeekDay(string $date): string
	{
		return date("l", strtotime($date));
	}
}
