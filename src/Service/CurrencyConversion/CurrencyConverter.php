<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CurrencyConversion;

final class CurrencyConverter extends AbstractCurrencyConverter
{
    public function convertFromEuro(string $currencyName, $eurAmount): string
    {
        $rate = $this->cm->getCurrencyConversionRate($currencyName);

        return (string) ($eurAmount * $rate);
    }

    public function convertToEuro(string $currencyName, $currencyAmount): string
    {
        $rate = 1 / $this->cm->getCurrencyConversionRate($currencyName);

        return (string) ($currencyAmount * $rate);
    }
}
