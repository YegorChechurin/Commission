<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\AbstractCashOutCommissionFeeCalculator;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\CommissionsManager;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;
use YegorChechurin\CommissionTask\Service\DateTimeOperations\DateChecker;

class NaturalCashOutCommissionFeeCalculator extends AbstractCashOutCommissionFeeCalculator
{
	protected $customerType = 'natural';

	private $dateChecker;

	private $feePercentage;

	private $freeOfChargeAmount;

	private $freeOfChargeNumOfOperations;

	private $userHistrory;

	public function __construct(CommissionsManager $cm, CurrencyConverterInterface $cc, CommissionFeeRounder $rounder, DateChecker $dateChecker)
	{
		parent::__construct($cm, $cc, $rounder);

		$this->dateChecker = $dateChecker;

		$this->feePercentage = $this->commissionParameters['fee'];

		$this->freeOfChargeAmount = $this->commissionParameters['free_of_charge']['amount'];

		$this->freeOfChargeNumOfOperations = $this->commissionParameters['free_of_charge']['number_of_operations'];

		$this->userHistrory = [];
	}

	public function calculateCommissionFee(array $operationParams): string
	{
		$userId = $operationParams['user_id'];
		$date = $operationParams['date'];
		$operationAmountEUR = $operationParams['amount'];

		if ('EUR' !== $operationParams['currency']) {
			$operationAmountEUR = $this->cc->convertToEuro($operationParams['currency'], $operationAmountEUR);
		} 

		if (array_key_exists($userId, $this->userHistrory)) {
			$this->updateUserHistoryRecord($userId, $date, $operationAmountEUR);
		} else {
			$this->createUserHistoryRecord($userId, $date, $operationAmountEUR);
		}

		$history = $this->userHistrory[$userId];

		if ($history['operation_count'] > $this->freeOfChargeNumOfOperations) {
			$feeInEUR = $this->feePercentage * $operationAmountEUR;
		} else {
			$feeInEUR = $this->calculateCommissionFeeInEuroWithDiscount($history, $operationAmountEUR);
		}

		if ('EUR' !== $operationParams['currency']) {
			$fee = $this->cc->convertFromEuro($operationParams['currency'], $feeInEUR); 
		} else {
			$fee = $feeInEUR;
		}

		return $this->rounder->round($operationParams['currency'], $fee);
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
