<?php

namespace YegorChechurin\CommissionTask\Service\CurrencyConversion\Exception;

class UnsupportedCurrencyException extends \RuntimeException
{
	public function __construct(string $currencyName)
	{
		parent::construct(sprintf('Currency with name "%s" is not supported for conversion', $currencyName));
	}
}
