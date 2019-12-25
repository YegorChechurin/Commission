<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CommissionFeeCalculation;

use PHPUnit\Framework\TestCase;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculator;
/*use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverter;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;*/
use DI;
use DI\ContainerBuilder;

class CommissionFeeCalculatorTest extends TestCase
{
	/**
     * @var CommissionFeeCalculator
     */
    private $calculator;

    public function setUp()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(
            dirname(__DIR__, 3).'/config/DI/container.php'
        );
        $container = $builder->build();

        $this->calculator = $container->get(CommissionFeeCalculator::class);
    }

    public function testCalculateCashInCommissionFee(){
    	//echo $this->calculator->calculateCashInCommissionFee('1000000', 'USD');

        var_dump(date("l", strtotime('2019-12-22')));

    	$this->assertTrue(true);
    }
}
