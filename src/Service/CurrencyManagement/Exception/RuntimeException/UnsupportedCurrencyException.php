<?php

namespace YegorChechurin\CommissionTask\Service\CurrencyManagement\Exception\RuntimeException;

class UnsupportedCurrencyException extends \RuntimeException
{
	public function __construct(string $currencyName)
	{
		parent::__construct(sprintf('Currency with name "%s" is not supported, you can not perform any operations on this currency', $currencyName));
	}
}
