<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CurrencyConversion;

use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CurrencyManagement\CurrenciesManager;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CurrencyManagement\Exception\RuntimeException\UnsupportedCurrencyException;

class CurrenciesManagerTest extends ContainerAwareTestCase
{
	/** 
	 * @var CurrenciesManager 
	 */
	private $currenciesManager;

	public function setUp()
	{
		$this->currenciesManager = $this->get(CurrenciesManager::class);
	}

	/** 
	 * @dataProvider conversionRateProvider 
	 */
	public function testGetCurrencyConversionRate(string $currencyName, string $expectation)
	{
		$this->assertEquals(
            $expectation,
            $this->currenciesManager->getCurrencyConversionRate($currencyName)
        );
	}

	public function conversionRateProvider(): array
	{
		return [
			['EUR', '1'],
			['USD', '1.1497'],
			['JPY', '129.53']
		];
	}

	/** 
	 * @dataProvider numberOfDecimalDigitsProvider 
	 */
	public function testGetNumberOfDecimalDigitsOfCurrencySmallestItem(string $currencyName, string $expectation)
	{
		$this->assertEquals(
            $expectation,
            $this->currenciesManager->getNumberOfDecimalDigitsOfCurrencySmallestItem($currencyName)
        );
	}

	public function numberOfDecimalDigitsProvider(): array
	{
		return [
			['EUR', '2'],
			['USD', '2'],
			['JPY', '0']
		];
	}

	/** 
	 * @dataProvider currencyIsSupportedProvider 
	 */
	public function testCheckCurrencyIsSupported(string $currencyName)
	{
		$this->expectException(UnsupportedCurrencyException::class);
		$this->expectExceptionMessage($currencyName);

		$this->currenciesManager->checkCurrencyIsSupported($currencyName);
	}

	public function currencyIsSupportedProvider(): array
	{
		return [
			['WhateverCurrency'],
		];
	}
}