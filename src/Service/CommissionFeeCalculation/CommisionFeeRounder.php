<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CurrencyManagement\CurrencyManager;
use YegorChechurin\CommissionTask\Service\Math\Math;

class CommissionFeeRounder
{
	/**
	 * @var CurrencyManager
	 */
	private $cm;

	/**
	 * @var Math
	 */
	private $math;

	public function __construct(CurrencyManager $cm, Math $math)
	{
		$this->cm = $cm;

		$this->math = $math;
	}

	public function round(string $currencyName, $commissionFee): string
	{
		$digitToRound = $this->cm->getNumberOfDecimalDigitsOfCurrencySmallestItem($currencyName);

		return $this->math->roundSpecificDigitAfterPointToUpperBound($commissionFee, $digitToRound);
	}
}
