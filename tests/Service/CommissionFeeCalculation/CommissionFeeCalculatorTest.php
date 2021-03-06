<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory\CommissionFeeCalculatorFactoryInterface;
use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;

class CommissionFeeCalculatorTest extends ContainerAwareTestCase
{
    private $calculatorFactory;

    public function setUp()
    {
        $this->calculatorFactory = $this->get(CommissionFeeCalculatorFactoryInterface::class);
    }

    /**
     * @dataProvider operationProvider
     */
    public function testCalculateCommissionFee(array $testData)
    {
        foreach ($testData as $data) {
            $this->assertEquals(
                $data['expectation'],
                $this->calculatorFactory
                    ->getCommissionFeeCalculator($data['operation'])
                    ->calculateCommissionFee($data['operation'])
            );
        }
    }

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
