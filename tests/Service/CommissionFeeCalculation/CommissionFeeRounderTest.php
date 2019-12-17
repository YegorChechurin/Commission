<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CommissionFeeCalculation;

use PHPUnit\Framework\TestCase;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;

class CommissionFeeRounderTest extends TestCase
{
	/**
	 * @var CommissionFeeRounder
	 */
	private $rounder;

	public function setUp()
	{
		$this->rounder = new CommissionFeeRounder();
	}

	/**
     * @dataProvider dataProviderForRoundTesting
     */
	public function testRound(string $currencyName, string $amountToRound, string $expectation)
	{
		$this->assertEquals(
            $expectation,
            $this->rounder->round($currencyName, $amountToRound)
        );
	}

	public function dataProviderForRoundTesting(): array
	{
		return [
			['EUR', '10.023', '10.03'],
			['USD', '5.131589', '5.14'],
		];
	}
}