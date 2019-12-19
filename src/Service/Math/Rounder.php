<?php

namespace YegorChechurin\CommissionTask\Service\Math;

use YegorChechurin\CommissionTask\Service\Math\Math;

class Rounder
{
	private $math;

	public function __construct(Math $math)
	{
		$this->math = $math;
	}

	public function roundSpecificDigitAfterPointToUpperBound($decimal, $positionAfterPoint)
	{
		$result = $decimal;

		if ($this->math->checkNumberIsDecimal($decimal)) {
			$originalParts = $this->math->splitDecimalIntoWholeAndFractional($decimal);
			$originalWhole = $originalParts['whole'];
			$originalFractional = $originalParts['fractional'];

			if ($positionAfterPoint > 0) {
				$originalFractionalChars = str_split($originalFractional);

				$digitToRound = $originalFractionalChars[$positionAfterPoint-1].'.';
				for ($i=$positionAfterPoint; $i < count($originalFractionalChars); $i++) { 
					$digitToRound .= $originalFractionalChars[$i];
				}

				$roundedDigit = ceil($digitToRound);

				$roundedFractional = '';
				for ($i=0; $i < $positionAfterPoint-1; $i++) { 
					$roundedFractional .= $originalFractionalChars[$i];
				}
				$roundedFractional .= $roundedDigit;
				
				$result = $originalWhole.'.'.$roundedFractional;
			} else {
				$originalWholeChars = str_split($originalWhole);

				$digitToRound = $originalWholeChars[count($originalWholeChars)-1].'.'; 
				$digitToRound .= $originalFractional;

				$roundedDigit = ceil($digitToRound);

				$result = $originalWholeChars;
				$result[count($originalWholeChars)-1] = $roundedDigit;
				$result = implode('', $result);
			}
		}

		return $result;
	}
}
