<?php

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory\CommissionFeeCalculatorFactoryInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory\SingletonCommissionFeeCalculatorFactory;
use YegorChechurin\CommissionTask\Service\FileParsing\FileParserFactoryInterface;
use YegorChechurin\CommissionTask\Service\FileParsing\FileParserFactory;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverterInterface;
use YegorChechurin\CommissionTask\Service\CurrencyConversion\CurrencyConverter;

use function DI\get;

return [
	FileParserFactoryInterface::class => get(FileParserFactory::class),
    CurrencyConverterInterface::class => get(CurrencyConverter::class),
    CommissionFeeCalculatorFactoryInterface::class => get(SingletonCommissionFeeCalculatorFactory::class),
];
