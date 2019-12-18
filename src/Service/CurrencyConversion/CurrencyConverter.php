<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CurrencyConversion;

use YegorChechurin\CommissionTask\Service\CurrencyManagement\CurrencyManager;

class CurrencyConverter implements CurrencyConverterInterface
{
	/**
	 * @var CurrencyManager
	 */
	private $cm;

	public function __construct(CurrencyManager $cm)
	{
		$this->cm = $cm;
	}

	public function convertFromEuro($currencyName, $eurAmount)
	{
		$rate = $this->cm->getCurrencyConversionRate($currencyName);

		return $eurAmount * $rate;
	}

	public function convertToEuro($currencyName, $currencyAmount)
	{
		$rate = 1 / $this->cm->getCurrencyConversionRate($currencyName);
		
		return $currencyAmount * $rate;
	}
}
