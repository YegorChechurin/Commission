<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;

class NaturalCashOutCommissionFeeCalculator extends AbstractCommissionFeeCalculator
{
    private $feePercentage;

    private $freeOfChargeAmount;

    private $freeOfChargeNumberOfOperations;

    /**
     * @var NaturalUserCashOutHistoryHandler
     */
    private $userHistoryHandler;

    public function __construct($feePercentage, $freeOfChargeAmount, $freeOfChargeNumberOfOperations,
                                CurrencyConverterInterface $cc, CommissionFeeRounder $rounder,
                                NaturalUserCashOutHistoryHandler $userHistoryHandler)
    {
        parent::__construct($cc, $rounder);

        $this->feePercentage = $feePercentage;

        $this->freeOfChargeAmount = $freeOfChargeAmount;

        $this->freeOfChargeNumberOfOperations = $freeOfChargeNumberOfOperations;

        $this->userHistoryHandler = $userHistoryHandler;
    }

    public function calculateCommissionFee(array $operationParams): string
    {
        $userId = $operationParams['user_id'];
        $date = $operationParams['date'];
        $operationAmountEUR = $operationParams['amount'];

        if ('EUR' !== $operationParams['currency']) {
            $operationAmountEUR = $this->convertToEuro($operationParams['currency'], $operationAmountEUR);
        }

        $history = $this->userHistoryHandler->getUserOperationsHistory($userId, $date, $operationAmountEUR);

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
