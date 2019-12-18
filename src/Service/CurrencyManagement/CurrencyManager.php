<?php

namespace YegorChechurin\CommissionTask\Service\CurrencyManagement;

use Symfony\Component\Yaml\Yaml;
use YegorChechurin\CommissionTask\Service\CurrencyManagement\Exception\RuntimeException\UnsupportedCurrencyException;

class CurrencyManager
{
	private const NUM_OF_DIR_TO_GO_UP_TO_CONFIG = 3;

	private const CONF_FILE_LOCATION = '/config/currencies.yaml';

	private $currencies;

	public function __construct()
	{
		$this->currencies = Yaml::parseFile(dirname(__DIR__, self::NUM_OF_DIR_TO_GO_UP_TO_CONFIG).self::CONF_FILE_LOCATION);
	}

	public function getCurrencyConversionRate(string $currencyName)
	{
		$this->checkCurrencyIsSupported($currencyName);

		return $this->currencies[$currencyName]['conversion_rate'];
	}

	public function getNumberOfDecimalDigitsOfCurrencySmallestItem(string $currencyName)
	{
		$this->checkCurrencyIsSupported($currencyName);
		
		return $this->currencies[$currencyName]['number_of_decimal_digits_of_smallest_item'];
	}

	public function checkCurrencyIsSupported(string $currencyName)
	{
		if (!in_array($currencyName, array_keys($this->currencies))) {
			throw new UnsupportedCurrencyException($currencyName);
		}
	}
}
