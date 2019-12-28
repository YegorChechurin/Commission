<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;

class CommissionFeeRounderTest extends ContainerAwareTestCase
{
	/**
	 * @var CommissionFeeRounder
	 */
	private $rounder;

	public function setUp()
	{
		$this->rounder = $this->get(CommissionFeeRounder::class);
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
			['EUR', '0', '0.00'],
			['EUR', '5', '5.00'],
			['USD', '5.131589', '5.14'],
			['USD', '5.199999', '5.20'],
			['JPY', '150', '150'],
			['JPY', '230.001', '231'],
		];
	}
}