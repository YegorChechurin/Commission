<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CurrencyConversion;

use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverter;

class CurrencyConverterTest extends ContainerAwareTestCase
{
	/** 
	 * @var CurrencyConverter 
	 */
	private $currencyConverter;

	public function setUp()
	{
		$this->currencyConverter = $this->get(CurrencyConverter::class);
	}

	/** 
	 * @dataProvider fromEuroConversionProvider 
	 */
	public function testConvertFromEuro(string $currencyName, string $eurAmount, string $expectation)
	{
		$this->assertEquals(
            $expectation,
            $this->currencyConverter->convertFromEuro(
            	$currencyName, $eurAmount
            )
        );
	}

	public function fromEuroConversionProvider(): array
	{
		return [
			['EUR', '100', '100'],
			['USD', '100', '114.97'],
			['JPY', '100', '12953'],
		];
	}

	/** 
	 * @dataProvider toEuroConversionProvider 
	 */
	public function testConvertToEuro(string $currencyName, string $currencyAmount, string $expectation)
	{
		$this->assertEquals(
            $expectation,
            $this->currencyConverter->convertToEuro(
            	$currencyName, $currencyAmount
            )
        );
	}

	public function toEuroConversionProvider(): array
	{
		return [
			['EUR', '100', '100'],
			['USD', '114.97', '100'],
			['JPY', '12953', '100'],
		];
	}
}
