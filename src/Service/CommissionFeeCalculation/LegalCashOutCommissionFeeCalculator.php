<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\AbstractCashOutCommissionFeeCalculator;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\CommissionsManager;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;

class LegalCashOutCommissionFeeCalculator extends AbstractCashOutCommissionFeeCalculator
{
	protected $customerType = 'legal';

	private $feePercentage;

	private $feeMinAmount;

	public function __construct(CommissionsManager $cm, CurrencyConverterInterface $cc, CommissionFeeRounder $rounder)
	{
		parent::__construct($cm, $cc, $rounder);

		$this->feePercentage = $this->commissionParameters['fee'];
		
		$this->feeMinAmount = $this->commissionParameters['minimum_amount'];
	}

	public function calculateCommissionFee(array $operationParams): string
	{
		$fee = $this->feePercentage * $operationParams['amount'];

		$feeInEUR = $this->cc->convertToEuro($operationParams['currency'], $fee);

		if ($feeInEUR < $this->feeMinAmount) {
			$feeInEUR = $this->feeMinAmount;
		} 

		$fee = $this->cc->convertFromEuro($operationParams['currency'], $feeInEUR);

		return $this->rounder->round($operationParams['currency'], $fee);
	}
}
