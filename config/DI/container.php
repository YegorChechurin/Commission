<?php

use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverter;

return [
    CurrencyConverterInterface::class => DI\get(CurrencyConverter::class),
];