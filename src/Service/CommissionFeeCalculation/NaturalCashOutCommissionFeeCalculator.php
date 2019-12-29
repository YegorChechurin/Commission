<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\AbstractCommissionFeeCalculator;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;
use YegorChechurin\CommissionTask\Service\DateTimeOperations\DateChecker;

class NaturalCashOutCommissionFeeCalculator extends AbstractCommissionFeeCalculator
{
	private $feePercentage;

	private $freeOfChargeAmount;

	private $freeOfChargeNumberOfOperations;

	private $userHistrory;

	private $dateChecker;

	public function __construct($feePercentage, $freeOfChargeAmount, $freeOfChargeNumberOfOperations, CurrencyConverterInterface $cc, CommissionFeeRounder $rounder, DateChecker $dateChecker)
	{
		parent::__construct($cc, $rounder);

		$this->feePercentage = $feePercentage;

		$this->freeOfChargeAmount = $freeOfChargeAmount;

		$this->freeOfChargeNumberOfOperations = $freeOfChargeNumberOfOperations;

		$this->userHistrory = [];

		$this->dateChecker = $dateChecker;
	}

	public function calculateCommissionFee(array $operationParams): string
	{
		$userId = $operationParams['user_id'];
		$date = $operationParams['date'];
		$operationAmountEUR = $operationParams['amount'];

		if ('EUR' !== $operationParams['currency']) {
			$operationAmountEUR = $this->convertToEuro($operationParams['currency'], $operationAmountEUR);
		} 

		if (array_key_exists($userId, $this->userHistrory)) {
			$this->updateUserHistoryRecord($userId, $date, $operationAmountEUR);
		} else {
			$this->createUserHistoryRecord($userId, $date, $operationAmountEUR);
		}

		$history = $this->userHistrory[$userId];

		if ($history['operation_count'] > $this->freeOfChargeNumberOfOperations) {
			$feeInEUR = $this->feePercentage * $operationAmountEUR;
		} else {
			$feeInEUR = $this->calculateCommissionFeeInEuroWithDiscount($history, $operationAmountEUR);
		}

		if ('EUR' !== $operationParams['currency']) {
			$fee = $this->convertFromEuro($operationParams['currency'], $feeInEUR); 
		} else {
			$fee = $feeInEUR;
		}

		return $this->roundCommissionFee($operationParams['currency'], $fee);
	}

	private function updateUserHistoryRecord(string $userId, string $date, string $operationAmountEUR)
	{
		if (!$this->dateChecker->checkDatesAreOnSameWeek($date, $this->userHistrory[$userId]['date'])) {
			$this->createUserHistoryRecord($userId, $date, $operationAmountEUR);
		} else {
			$this->userHistrory[$userId]['operation_count']++;
			$this->userHistrory[$userId]['total_amount_in_euro'] += $operationAmountEUR;
			$this->userHistrory[$userId]['date'] = $date;
		}
	}

	private function createUserHistoryRecord(string $userId, string $date, string $operationAmountEUR)
	{
		$this->userHistrory[$userId] = [
				'operation_count' => 1,
				'date' => $date,
				'total_amount_in_euro' => $operationAmountEUR,
			];
	}

	private function calculateCommissionFeeInEuroWithDiscount(array $history, string $operationAmountEUR): string
	{
		$feeInEUR = '0.00';

		if ($history['total_amount_in_euro'] - $operationAmountEUR > $this->freeOfChargeAmount) {
			$feeInEUR = $this->feePercentage * $operationAmountEUR;
		} else {
			if ($history['total_amount_in_euro'] > $this->freeOfChargeAmount) {
				$feeInEUR = $this->feePercentage * ($history['total_amount_in_euro'] - $this->freeOfChargeAmount);
			}
		}

		return $feeInEUR;
	}
}
