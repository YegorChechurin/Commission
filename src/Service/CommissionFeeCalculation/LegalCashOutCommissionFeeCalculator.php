<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\AbstractCommissionFeeCalculator;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;

class LegalCashOutCommissionFeeCalculator extends AbstractCommissionFeeCalculator
{
	private $feePercentage;

	private $feeMinimumAmount;

	public function __construct($feePercentage, $feeMinimumAmount, CurrencyConverterInterface $cc, CommissionFeeRounder $rounder)
	{
		parent::__construct($cc, $rounder);

		$this->feePercentage = $feePercentage;
		
		$this->feeMinimumAmount = $feeMinimumAmount;
	}

	public function calculateCommissionFee(array $operationParams): string
	{
		$fee = $this->feePercentage * $operationParams['amount'];

		$feeInEUR = $this->convertToEuro($operationParams['currency'], $fee);

		if ($feeInEUR < $this->feeMinimumAmount) {
			$feeInEUR = $this->feeMinimumAmount;
		} 

		$fee = $this->convertFromEuro($operationParams['currency'], $feeInEUR);

		return $this->roundCommissionFee($operationParams['currency'], $fee);
	}
}
