<?php

namespace YegorChechurin\CommissionTask\Service\CurrencyConversion;

interface CurrencyConverterInterface
{
	public function convert(string $inputCurrency, string $outputCurrency, string $amountOfInputCurrency): string
}