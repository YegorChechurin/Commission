<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\AbstractCommissionFeeCalculator;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\CommissionsManager;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;

class CashInCommissionFeeCalculator extends AbstractCommissionFeeCalculator
{
	protected $operationName = 'cash_in'; 

	private $feePercentage;

	private $feeMaxAmount;

	public function __construct(CommissionsManager $cm, CurrencyConverterInterface $cc, CommissionFeeRounder $rounder)
	{
		parent::__construct($cm, $cc, $rounder);

		$this->feePercentage = $this->commissionParameters['fee'];
		
		$this->feeMaxAmount = $this->commissionParameters['maximum_amount'];
	}

	public function calculateCommissionFee(array $operationParams): string
	{
		$fee = $this->feePercentage * $operationParams['amount'];

		$feeInEUR = $this->cc->convertToEuro($operationParams['currency'], $fee);

		if ($feeInEUR > $this->feeMaxAmount) {
			$feeInEUR = $this->feeMaxAmount;
		} 

	    $fee = $this->cc->convertFromEuro($operationParams['currency'], $feeInEUR);

		return $this->rounder->round($operationParams['currency'], $fee);
	}
}
