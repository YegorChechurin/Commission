<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CurrencyConversion;

interface CurrencyConverterInterface
{
    public function convertFromEuro(string $currencyName, $amountInEUR);

    public function convertToEuro(string $currencyName, $amountInCurrencyToBeConverted);
}
