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
    public function testCalculateCommissionFee(array $testData)
    {//var_dump($testData);
        foreach ($testData as $data) {
            //var_dump($data);
            $this->assertEquals(
                $data['expectation'],
                $this->calculator->calculateCommissionFee($data['operation'])
            );
        }
    }
    /*public function testCalculateCommissionFee(array $operationParams, string $expectation){
        $this->assertEquals(
            $expectation,
            $this->calculator->calculateCommissionFee($operationParams)
        );
    }*/

    public function operationProvider()
    {
        return [[[
            [
                'operation' => [
                    'date' => '2014-12-31',
                    'user_id' => '4',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1200.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '0.60'
            ],
            [
                'operation' => [
                    'date' => '2015-01-01',
                    'user_id' => '4',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1000.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '3.00'
            ],
            [
                'operation' => [
                    'date' => '2016-01-05',
                    'user_id' => '4',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1000.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '0.00'
            ],
            [
                'operation' => [
                    'date' => '2016-01-05',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_in',
                    'amount' => '200.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '0.06'
            ],
            [
                'operation' => [
                    'date' => '2016-01-06',
                    'user_id' => '2',
                    'user_type' => 'legal',
                    'name' => 'cash_out',
                    'amount' => '300.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '0.90'
            ],
            [
                'operation' => [
                    'date' => '2016-01-06',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '30000',
                    'currency' => 'JPY',
                ],
                'expectation' => '0'
            ],
            [
                'operation' => [
                    'date' => '2016-01-07',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1000.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '0.70'
            ],
            [
                'operation' => [
                    'date' => '2016-01-07',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '100.00',
                    'currency' => 'USD',
                ],
                'expectation' => '0.30'
            ],
            [
                'operation' => [
                    'date' => '2016-01-10',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '100.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '0.30'
            ],
            [
                'operation' => [
                    'date' => '2016-01-10',
                    'user_id' => '2',
                    'user_type' => 'legal',
                    'name' => 'cash_in',
                    'amount' => '1000000.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '5.00'
            ],
            [
                'operation' => [
                    'date' => '2016-01-10',
                    'user_id' => '3',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1000.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '0.00'
            ],
            [
                'operation' => [
                    'date' => '2016-02-15',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '300.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '0.00'
            ],
            [
                'operation' => [
                    'date' => '2016-02-19',
                    'user_id' => '5',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '3000000',
                    'currency' => 'JPY',
                ],
                'expectation' => '8612'
            ],
        ]]];
    }
}
