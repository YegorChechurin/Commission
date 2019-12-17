<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;

class CommissionFeeCalculator
{
	private const CASH_IN_DEFAULT_FEE = 0.0003;

	private const CASH_IN_MAX_FEE = 5.00;

	private $currencyConverter;

	private $rounder;

	public function __construct(CurrencyConverterInterface $currencyConverter, CommissionFeeRounder $rounder)
	{
		$this->currencyConverter = $currencyConverter;

		$this->rounder = $rounder;
	}

	public function calculateCashInCommissionFee(string $cashInAmount, string $cashInCurrency)
	{
		$fee = self::CASH_IN_DEFAULT_FEE * $cashInAmount;

		if ('EUR' === $cashCurrency && $fee > self::CASH_IN_MAX_FEE) {
			$fee = self::CASH_IN_MAX_FEE; 
		} elseif ('EUR' !== $cashCurrency) {
			$feeInEUR = $this->currencyConverter->convertToEuro($cashInCurrency, $fee);

			if ($feeInEUR > self::CASH_IN_MAX_FEE) {
				$fee = $this->currencyConverter->convertFromEuro($cashInCurrency, self::CASH_IN_MAX_FEE);
			} else {
				$fee = $this->currencyConverter->convertFromEuro($cashInCurrency, $feeInEUR);
			}
		}

		return $this->rounder->round($cashInCurrency, $fee);
	}
}
