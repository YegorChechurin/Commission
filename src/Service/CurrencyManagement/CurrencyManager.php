<?php

namespace YegorChechurin\CommissionTask\Service\CurrencyManagement;

class CurrencyManager
{
	private $currencyConfig;

	public function __construct()
	{
		$this->currencyConfig = \yaml_parse_file(dirname(__DIR__, 3).'/config/currencies.yaml');
	}

	public function getConfig()
	{
		return $this->currencyConfig;
	}
}
