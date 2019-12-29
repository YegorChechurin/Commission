<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory;

class LegalCashOutCommissionFeeCalculatorTest extends ContainerAwareTestCase
{
	/**
     * @var CommissionFeeCalculatorFactory
     */
    private $calculatorFactory;

    public function setUp()
    {
        $this->calculatorFactory = $this->get(CommissionFeeCalculatorFactory::class);
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
                    'date' => '2016-01-06',
                    'user_id' => '2',
                    'user_type' => 'legal',
                    'name' => 'cash_out',
                    'amount' => '300.00',
                    'currency' => 'EUR',
                ],
                'expectation' => '0.90'
            ],
        ]]];
    }
}
