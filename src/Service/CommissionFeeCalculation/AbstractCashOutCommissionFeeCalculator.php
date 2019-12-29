<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\AbstractCommissionFeeCalculator;

abstract class AbstractCashOutCommissionFeeCalculator extends AbstractCommissionFeeCalculator
{
	protected $operationName = 'cash_out';
	
	protected $customerType;

	protected function getCommissionParameters(): array
	{
		$this->checkCustomerTypeIsSet();

		$cashOutCommissionParameters = parent::getCommissionParameters();

		return $cashOutCommissionParameters[$this->customerType];
	}

	protected function checkCustomerTypeIsSet()
	{
		if (!$this->customerType) {
			throw new CustomerTypeIsNotSetException(getThisClassName());
		}
	}
}
