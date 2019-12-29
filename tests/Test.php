<?php

namespace YegorChechurin\CommissionTask\Tests;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory;

class Test extends ContainerAwareTestCase
{
	private $factory;

	public function setUp()
	{
		$this->factory = $this->get(CommissionFeeCalculatorFactory::class);
	}

	public function test()
	{//$this->factory->test();
		var_dump(
			$this->factory->getCommissionFeeCalculator(
				[
                    'date' => '2014-12-31',
                    'user_id' => '4',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1200.00',
                    'currency' => 'EUR',
                ]
			)
		);

		$this->assertTrue(true);
	}
}
