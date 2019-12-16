<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CurrencyConversion;

use YegorChechurin\CommissionTask\Service\CurrencyConversion\Exception\UnsupportedCurrenciesFoundException;

class CurrencyConverter implements CurrencyConverterInterface
{
	private const EUR_USD_RATE = 1.1497;

	private const EUR_JPY_RATE = 129.53;

	private $supportedCurrencies = ['EUR', 'USD', 'JPY'];

	public function convert(string $inputCurrency, string $outputCurrency, string $amountOfInputCurrency): string
	{}

	private function checkCurrenciesAreSupported(string $inputCurrency, string $outputCurrency): void
	{
		$currencies = [$inputCurrency, $outputCurrency];
		$notSupportedCurrencies = [];

		foreach ($currencies as $c) {
			if (!in_array($c, $this->supportedCurrencies)) {
			    $notSupportedCurrencies[] = $c;
		    }
		}

		if (count($notSupportedCurrencies) > 0) {
			throw UnsupportedCurrenciesFoundException(
				'These currencies are not supported for conversion: '.implode(' ', $notSupportedCurrencies)
			);
		}
	}
}