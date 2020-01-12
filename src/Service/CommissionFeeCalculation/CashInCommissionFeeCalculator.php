<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;

class CashInCommissionFeeCalculator extends AbstractCommissionFeeCalculator
{
    private $feePercentage;

    private $feeMaximumAmount;

    public function __construct($feePercentage, $feeMaximumAmount, CurrencyConverterInterface $cc, CommissionFeeRounder $rounder)
    {
        parent::__construct($cc, $rounder);

        $this->feePercentage = $feePercentage;

        $this->feeMaximumAmount = $feeMaximumAmount;
    }

    public function calculateCommissionFee(array $operationParams): string
    {
        $fee = $this->feePercentage * $operationParams['amount'];

        $feeInEUR = $this->convertToEuro($operationParams['currency'], $fee);

        if ($feeInEUR > $this->feeMaximumAmount) {
            $feeInEUR = $this->feeMaximumAmount;
        }

        $fee = $this->convertFromEuro($operationParams['currency'], $feeInEUR);

        return $this->roundCommissionFee($operationParams['currency'], (string) $fee);
    }
}
