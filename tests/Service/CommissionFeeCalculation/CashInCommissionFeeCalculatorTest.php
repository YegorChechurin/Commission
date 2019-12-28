<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CashInCommissionFeeCalculator;

class CashInCommissionFeeCalculatorTest extends ContainerAwareTestCase
{
	/**
     * @var CashInCommissionFeeCalculator
     */
    private $calculator;

    public function setUp()
    {
    	$this->calculator = $this->get(CashInCommissionFeeCalculator::class);
    }

    /**
     * @dataProvider operationProvider
     */
    public function testCalculateCommissionFee(array $testData)
    {
        foreach ($testData as $data) {
            $this->assertEquals(
                $data['expectation'],
                $this->calculator->calculateCommissionFee($data['operation'])
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
