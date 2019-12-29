<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\LegalCashOutCommissionFeeCalculator;

class LegalCashOutCommissionFeeCalculatorTest extends ContainerAwareTestCase
{
	/**
     * @var LegalCashOutCommissionFeeCalculator
     */
    private $calculator;

    public function setUp()
    {
    	$this->calculator = $this->get(LegalCashOutCommissionFeeCalculator::class);
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
                    'date' => '2016-01-10',
                    'user_id' => '2',
                    'user_type' => 'legal',
                    'name' => 'cash_in',
                    'amount' => '1000000.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '3000.00'
            ],
        ]]];
    }
}
