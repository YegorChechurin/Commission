<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CurrencyManagement\CurrenciesManager;
use YegorChechurin\CommissionTask\Service\Math\Math;

class CommissionFeeRounder
{
    /**
     * @var CurrenciesManager
     */
    private $cm;

    /**
     * @var Math
     */
    private $math;

    public function __construct(CurrenciesManager $cm, Math $math)
    {
        $this->cm = $cm;

        $this->math = $math;
    }

    public function round(string $currencyName, string $commissionFee): string
    {
        $digitToRound = $this->cm->getNumberOfDecimalDigitsOfCurrencySmallestItem($currencyName);

        if ($this->math->checkNumberIsDecimal($commissionFee)) {
            $commissionFee = $this->math->roundSpecificDigitAfterPointToUpperBound($commissionFee, $digitToRound);
        } else {
            $commissionFee = $this->math->convertIntegerToFloat($commissionFee, $digitToRound);
        }

        return $commissionFee;
    }
}
