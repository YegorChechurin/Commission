<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;

abstract class AbstractCommissionFeeCalculator implements CommissionFeeCalculatorInterface
{
    /**
     * @var CurrencyConverter
     */
    protected $cc;

    /**
     * @var CommissionFeeRounder
     */
    protected $rounder;

    abstract public function calculateCommissionFee(array $operationParameters): string;

    public function __construct(CurrencyConverterInterface $cc, CommissionFeeRounder $rounder)
    {
        $this->cc = $cc;

        $this->rounder = $rounder;
    }

    protected function convertToEuro(string $currencyName, $amount)
    {
        return $this->cc->convertToEuro($currencyName, $amount);
    }

    protected function convertFromEuro(string $currencyName, $amount)
    {
        return $this->cc->convertFromEuro($currencyName, $amount);
    }

    protected function roundCommissionFee(string $currencyName, string $commissionFee): string
    {
        return $this->rounder->round($currencyName, $commissionFee);
    }
}
