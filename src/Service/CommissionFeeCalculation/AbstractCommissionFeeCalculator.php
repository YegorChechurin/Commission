<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorInterface;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\CommissionsManager;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeRounder;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\Exception\LogicException\OperationNameIsNotSetException;

abstract class AbstractCommissionFeeCalculator implements CommissionFeeCalculatorInterface
{
	/** 
	 * @var CommissionsManager 
	 */
	protected $cm;

	/** 
	 * @var CurrencyConverter 
	 */
	protected $cc;

	/** 
	 * @var CommissionFeeRounder 
	 */
	protected $rounder;

	protected $commissionParameters;

	protected $operationName;

	abstract public function calculateCommissionFee(array $operationParameters): string;

	public function __construct(CommissionsManager $cm, CurrencyConverterInterface $cc, CommissionFeeRounder $rounder)
	{
		$this->cm = $cm;

		$this->cc = $cc;

		$this->rounder = $rounder;

		$this->commissionParameters = $this->getCommissionParameters();
	}

	protected function getCommissionParameters(): array
	{
		$this->checkOperationNameIsSet();

		return $this->cm->getCommissionParameters($this->operationName);
	}

	protected function checkOperationNameIsSet()
	{
		if (!$this->operationName) {
			throw new OperationNameIsNotSetException($this->getThisClassName());
		}
	}

	protected function getThisClassName(): string
	{
		return (new \ReflectionClass($this))->getName();
	}
}
