<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CurrencyConversion;

use YegorChechurin\CommissionTask\Service\CurrencyConversion\Exception\UnsupportedCurrencyException;

class CurrencyConverter implements CurrencyConverterInterface
{
	private const CONVERSION_RATES = [
		'USD' => 1.1497,
		'JPY' => 129.53,
	];

	public function convertFromEuro($currencyName, $eurAmount)
	{
		$this->checkCurrencyIsSupported($currencyName);

		return $eurAmount * $this->getConversionRate($currencyName);
	}

	public function convertToEuro($currencyName, $currencyAmount)
	{
		$this->checkCurrencyIsSupported($currencyName);
		
		return $currencyAmount * $this->getReverseConversionRate($currencyName);
	}

	private function getConversionRate(string $currencyName)
	{
		return self::CONVERSION_RATES[$currencyName];
	}

	private function getReverseConversionRate(string $currencyName)
	{
		return 1 / $this->getConversionRate($currencyName);
	}

	private function checkCurrencyIsSupported(string $currencyName): void
	{
		if (!in_array($currencyName, array_keys(self::CONVERSION_RATES))) {
			throw UnsupportedCurrencyException($currencyName);
		}
	}
}
