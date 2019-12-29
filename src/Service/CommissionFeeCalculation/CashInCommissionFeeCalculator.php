<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\AbstractCommissionFeeCalculator;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;

class CashInCommissionFeeCalculator extends AbstractCommissionFeeCalculator
{
	private $feePercentage;

	private $feeMaximumAmount;

	public function __construct($feePercentage, $feeMaximumAmount, CurrencyConverterInterface $cc, CommissionFeeRounder $rounder)
	{
		parent::__construct($cc, $rounder);

		$this->feePercentage = $feePercentage;
		
		$this->feeMaximumAmount = $feeMaximumAmount;
	}

	public function calculateCommissionFee(array $operationParams): string
	{
		$fee = $this->feePercentage * $operationParams['amount'];

		$feeInEUR = $this->convertToEuro($operationParams['currency'], $fee);

		if ($feeInEUR > $this->feeMaximumAmount) {
			$feeInEUR = $this->feeMaximumAmount;
		} 

	    $fee = $this->convertFromEuro($operationParams['currency'], $feeInEUR);

		return $this->roundCommissionFee($operationParams['currency'], $fee);
	}
}
