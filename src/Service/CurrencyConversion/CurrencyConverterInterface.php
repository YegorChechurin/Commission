<?php

namespace YegorChechurin\CommissionTask\Service\CurrencyConversion;

interface CurrencyConverterInterface
{
	public function convertFromEuro($currencyName, $amountInEUR);
	
	public function convertToEuro($currencyName, $amountInCurrencyToBeConverted);
}
