<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings\CurrencyManagement;

use YegorChechurin\CommissionTask\Service\DomainLogicSettings\AbstractSettingsManager;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CurrencyManagement\Exception\RuntimeException\UnsupportedCurrencyException;

class CurrenciesManager extends AbstractSettingsManager
{
	public function getCurrencyConversionRate(string $currencyName)
	{
		$this->checkCurrencyIsSupported($currencyName);

		return $this->settings[$currencyName]['conversion_rate'];
	}

	public function getNumberOfDecimalDigitsOfCurrencySmallestItem(string $currencyName)
	{
		$this->checkCurrencyIsSupported($currencyName);
		
		return $this->settings[$currencyName]['number_of_decimal_digits_of_smallest_item'];
	}

	public function checkCurrencyIsSupported(string $currencyName)
	{
		if (!in_array($currencyName, array_keys($this->settings))) {
			throw new UnsupportedCurrencyException($currencyName);
		}
	}
}