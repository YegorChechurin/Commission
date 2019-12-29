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
	{$this->factory->test();
		/*echo $this->factory->getCommissionFeeCalculator(
			['name' => 'cash_without', 'user_type' => 'legal']
		);*/

		$this->assertTrue(true);
	}
}
