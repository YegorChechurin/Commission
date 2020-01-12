<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CurrencyConversion;

use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CurrencyManagement\CurrenciesManager;

abstract class AbstractCurrencyConverter implements CurrencyConverterInterface
{
    /**
     * @var CurrenciesManager
     */
    protected $cm;

    abstract public function convertFromEuro(string $currencyName, $amountInEUR);

    abstract public function convertToEuro(string $currencyName, $amountInCurrencyToBeConverted);

    public function __construct(CurrenciesManager $cm)
    {
        $this->cm = $cm;
    }
}
