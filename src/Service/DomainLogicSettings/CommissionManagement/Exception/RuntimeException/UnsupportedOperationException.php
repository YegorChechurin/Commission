<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\Exception\RuntimeException;

class UnsupportedOperationException extends \RuntimeException
{
	public function __construct(string $operationName)
	{
		parent::__construct(
			sprintf('Operation with name "%s" is not supported, it is not possible to calculate commission fee for this operation', $operationName)
		);
	}
}
