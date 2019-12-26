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

    /**
     * @dataProvider operationProvider
     */
    public function testCalculateCommissionFee(array $operationParams, string $expectation){
    }

    public function operationProvider()
    {
        return [
            [
                [
                    'date' => '2014-12-31',
                    'user_id' => '4',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1200.00',
                    'currency' => 'EUR',
                ],
                '0.60'
            ],
            [
                [
                    'date' => '2015-01-01',
                    'user_id' => '4',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1000.00',
                    'currency' => 'EUR',
                ],
                '3.00'
            ],
            [
                [
                    'date' => '2016-01-05',
                    'user_id' => '4',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1000.00',
                    'currency' => 'EUR',
                ],
                '0.00'
            ],
            /*[
                [
                    'date' => '',
                    'user_id' => '',
                    'user_type' => '',
                    'name' => '',
                    'amount' => '',
                    'currency' => '',
                ],
                ''
            ],*/
        ];
    }
}
