<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CurrencyConversion;

final class CurrencyConverter extends AbstractCurrencyConverter
{
	public function convertFromEuro(string $currencyName, $eurAmount)
	{
		$rate = $this->cm->getCurrencyConversionRate($currencyName);

		return $eurAmount * $rate;
	}

	public function convertToEuro(string $currencyName, $currencyAmount)
	{
		$rate = 1 / $this->cm->getCurrencyConversionRate($currencyName);
		
		return $currencyAmount * $rate;
	}
}
