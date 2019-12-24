<?php

namespace YegorChechurin\CommissionTask\Service\Math\Exception\LogicException;

class InvalidPostionAfterPointException extends \LogicException
{
	public function __construct()
	{
		parent::__construct(
			'Position of digit after point which you would like to round to cannot be negative, it can be either positive or zero'
		);
	}
}