<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CurrencyManagement\CurrencyManager;
use YegorChechurin\CommissionTask\Service\Math\Rounder;

class CommissionFeeRounder
{
	/**
	 * @var CurrencyManager
	 */
	private $cm;

	/**
	 * @var Rounder
	 */
	private $rounder;

	public function __construct(CurrencyManager $cm, Rounder $rounder)
	{
		$this->cm = $cm;

		$this->rounder = $rounder;
	}

	public function round(string $currencyName, $commissionFee)
	{
		$digitToRound = $this->cm->getNumberOfDecimalDigitsOfCurrencySmallestItem($currencyName);

		return $this->rounder->roundSpecificDigitAfterPointToUpperBound($commissionFee, $digitToRound);
	}
}
