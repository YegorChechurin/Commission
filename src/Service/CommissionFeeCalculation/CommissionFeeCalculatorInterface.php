<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

interface CommissionFeeCalculatorInterface
{
	public function calculateCommissionFee(array $operationParameters): string;
}
