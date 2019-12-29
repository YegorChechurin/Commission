<?php

namespace YegorChechurin\CommissionTask\Service\Math;

use YegorChechurin\CommissionTask\Service\Math\Exception\LogicException\NumberIsNotDecimalException;
use YegorChechurin\CommissionTask\Service\Math\Exception\RuntimeException\CheckNumberIsDecimalException;
use YegorChechurin\CommissionTask\Service\Math\Exception\LogicException\InvalidPostionAfterPointException;

class Math
{
    public function roundSpecificDigitAfterPointToUpperBound(string $decimal, int $positionAfterPoint): string
    {
        if (!$this->checkNumberIsDecimal($decimal)) {
            throw new NumberIsNotDecimalException($decimal);
        }

        if ($positionAfterPoint < 0) {
            throw new InvalidPostionAfterPointException();
        }

        list($originalWhole, 
                $originalFractional) = $this->splitDecimalIntoWholeAndFractional($decimal);

        if ($positionAfterPoint > 0) {
            $originalFractionalChars = str_split($originalFractional);

            if (count($originalFractionalChars) < $positionAfterPoint) {
                $result = $decimal;
                for ($i = count($originalFractionalChars) - 1; $i < $positionAfterPoint - 1; $i++) { 
                    $result .= '0';
                }
            } else {
                $digitToRound = $originalFractionalChars[$positionAfterPoint-1].'.';
                for ($i = $positionAfterPoint; $i < count($originalFractionalChars); $i++) { 
                    $digitToRound .= $originalFractionalChars[$i];
                }

                $roundedDigit = ceil($digitToRound);

                $stack1 = new \SplStack();
                for ($i=0; $i < $positionAfterPoint-1; $i++) { 
                    $stack1->push($originalFractionalChars[$i]);
                }
                $stack1->push($roundedDigit);

                $stack2 = new \SplStack();
                for ($i=0; $i < $positionAfterPoint; $i++) { 
                    $digit = $stack1->pop();

                    if (!empty($plusFlag)) {
                        $digit++;
                    } 

                    if ($digit == 10) {
                        $digit = '0';
                        $plusFlag = true;
                    } else {
                        $plusFlag = false;
                    }

                    $stack2->push($digit);
                }

                $roundedFractional = '';
                for ($i=0; $i < $positionAfterPoint; $i++) { 
                    $roundedFractional .= $stack2->pop();
                }
            
                $result = $originalWhole.'.'.$roundedFractional;
            }
        } else {
            $originalWholeChars = str_split($originalWhole);

            $digitToRound = $originalWholeChars[count($originalWholeChars)-1].'.'; 
            $digitToRound .= $originalFractional;

            $roundedDigit = ceil($digitToRound);

            $result = $originalWholeChars;
            $result[count($originalWholeChars)-1] = $roundedDigit;
            $result = implode('', $result);
        }

        return $result;
    }

    public function checkNumberIsDecimal(string $number): bool
    {
        $isDecimal = true;

        if (1 === preg_match('%\.%', $number)) {
            $parts = explode('.', $number);

            if (count($parts) !== 2) {
                throw new CheckNumberIsDecimalException($number);
            }

            foreach ($parts as $p) {
                if (!ctype_digit($p)) {
                    throw new CheckNumberIsDecimalException($number);
                }
            }
        } elseif ((int)0 === preg_match('%\.%', $number)) {
            if (!ctype_digit($number)) { 
                throw new CheckNumberIsDecimalException($number);
            } else {
                $isDecimal = false;
            }
        } else {
            throw new CheckNumberIsDecimalException($number);
        }

        return $isDecimal;
    }

    public function splitDecimalIntoWholeAndFractional(string $decimal): array
    {
        if ($this->checkNumberIsDecimal($decimal)) {
            return explode('.', $decimal);
        } else {
            throw new NumberIsNotDecimalException($decimal);
        }
    }

    public function convertIntegerToFloat(string $integer, int $numberOfDigitsAfterPoint): string
    {
        if ($numberOfDigitsAfterPoint < 0) {
            throw new InvalidPostionAfterPointException();
        }

        $result = $integer;

        if ($numberOfDigitsAfterPoint > 0) {
            $result = number_format($result, $numberOfDigitsAfterPoint, '.', '');
        }

        return $result;
    }
}
