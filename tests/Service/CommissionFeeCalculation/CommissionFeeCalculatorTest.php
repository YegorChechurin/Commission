<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CommissionFeeCalculation;

use PHPUnit\Framework\TestCase;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculator;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverter;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;

class CommissionFeeClaculatorTest extends TestCase
{
	/**
     * @var CommissionFeeCalculator
     */
    private $calculator;

    public function setUp()
    {
        $converter = new CurrencyConverter();
        $rounder = new CommissionFeeRounder();
        $this->calculator = new CommissionFeeCalculator($converter, $rounder);
    }

    public function testCalculateCashInCommissionFee(){
    	echo $this->calculator->calculateCashInCommissionFee('1000000', 'USD');

    	$this->assertTrue(true);
    }
}
