<?php

namespace YegorChechurin\CommissionTask\Tests;

use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverter;

class Test extends ContainerAwareTestCase
{
	private $currencyConverter;

	public function setUp()
	{
		$this->currencyConverter = $this->container->get(CurrencyConverter::class);
	}

	public function test()
	{
		var_dump($this->currencyConverter->convertFromEuro('EUR', 100500));

		$this->assertTrue(true);
	}
}
