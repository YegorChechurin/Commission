<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\Exception\LogicException;

class CustomerTypeIsNotSetException extends \LogicException
{
	public function __construct(string $commissionFeeCalculatorClassName)
	{
		parent::__construct(
			sprintf('You have not set customer type in class %s', $commissionFeeCalculatorClassName)
		);
	}
}
