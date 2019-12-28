<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\Exception\LogicException;

class OperationNameIsNotSetException extends \LogicException
{
	public function __construct(string $commissionFeeCalculatorClassName)
	{
		parent::__construct(
			sprintf('You have not set operation name in class %s', $commissionFeeCalculatorClassName)
		);
	}
}
