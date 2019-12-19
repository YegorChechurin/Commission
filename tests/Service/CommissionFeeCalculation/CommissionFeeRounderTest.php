<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CommissionFeeCalculation;

use PHPUnit\Framework\TestCase;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;
use DI;
use DI\ContainerBuilder;

class CommissionFeeRounderTest extends TestCase
{
	/**
	 * @var CommissionFeeRounder
	 */
	private $rounder;

	public function setUp()
	{
		$builder = new ContainerBuilder();
        $builder->addDefinitions(
            dirname(__DIR__, 3).'/config/DI/container.php'
        );
        $container = $builder->build();

		$this->rounder = $container->get(CommissionFeeRounder::class);
	}

	/**
     * @dataProvider dataProviderForRoundTesting
     */
	public function testRound(string $currencyName, string $amountToRound, string $expectation)
	{
		//var_dump(explode('.', '125'));
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
			['JPY', '150', '150'],
			['JPY', '230.001', '231'],
		];
	}
}