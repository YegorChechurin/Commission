<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

class CommissionFeeRounder
{
	/**
	 * @var array DECIMAL_DIGITS numbers of decimal digits to round to for
	 * each currency
	 */
	private const DECIMAL_DIGITS = [
		'EUR' => 2,
		'USD' => 2,
		'JPY' => 0,
	];

	public function round(string $currencyName, $amount)
	{
		$numOfDecDigits = self::DECIMAL_DIGITS[$currencyName];

		$originalParts = $this->splitDecimalIntoWholeAndFractional($amount);
    	$originalWhole = $originalParts['whole'];
    	$originalFractional = $originalParts['fractional'];
    	$originalFractionalChars = $this->splitStringIntoArrayOfChars($originalFractional);

    	$smallestCurrencyItem = $originalFractionalChars[$numOfDecDigits-1].'.';
    	for ($i=$order; $i < count($originalFractionalChars); $i++) { 
    		$smallestCurrencyItem .= $originalFractionalChars[$i];
    	}
    	$smallestCurrencyItem = $this->roundSmallestCurrencyItemToUpperBound($smallestCurrencyItem);

    	$roundedFractional = '';
    	for ($i=0; $i < $numOfDecDigits-1; $i++) { 
    		$roundedFractional .= $originalFractionalChars[$i];
    	}
    	$roundedFractional .= $smallestCurrencyItem;
    	
    	return $originalWhole.'.'.$roundedFractional;
	}

	private function splitDecimalIntoWholeAndFractional($decimal): array
	{
		$parts = explode('.', strval($decimal));

		return [
			'whole' => $parts[0],
			'fractional' => $parts[1],
		];
	}

	private function splitStringIntoArrayOfChars(string $string): array
	{
		return str_split($string);
	}

	private function roundSmallestCurrencyItemToUpperBound($item)
	{
		return ceil($item); 
	}
}
