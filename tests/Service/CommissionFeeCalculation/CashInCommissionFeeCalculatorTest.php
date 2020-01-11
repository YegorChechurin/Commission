<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory\CommissionFeeCalculatorFactoryInterface;
use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;

class CashInCommissionFeeCalculatorTest extends ContainerAwareTestCase
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
                    'date' => '2016-01-10',
                    'user_id' => '2',
                    'user_type' => 'legal',
                    'name' => 'cash_in',
                    'amount' => '1000000.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '5.00'
            ],
        ]]];
    }
}
