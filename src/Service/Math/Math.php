<?php

//declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\Math;

use YegorChechurin\CommissionTask\Service\Math\Exception\LogicException\NumberIsNotDecimalException;
use YegorChechurin\CommissionTask\Service\Math\Exception\RuntimeException\CheckNumberIsDecimalException;
use YegorChechurin\CommissionTask\Service\Math\Exception\LogicException\InvalidPostionAfterPointException;

class Math
{
    /*private $scale;

    public function __construct(int $scale)
    {
        $this->scale = $scale;
    }

    public function add(string $leftOperand, string $rightOperand): string
    {
        return bcadd($leftOperand, $rightOperand, $this->scale);
    }

    public function multiply(string $leftOperand, string $rightOperand): string
    {
        return bcmul($leftOperand, $rightOperand, $this->scale);
    }*/

    /*public function checkNumberIsDecimal($number): bool
    {
        if (1 === preg_match('%\.%', $number) && ctype_digit($number)) {
            return true;
        } elseif ((int)0 === preg_match('%\.%', $number) && ctype_digit($number)) {
            return false;
        } else {
            throw new CheckNumberIsDecimalException((string) $number);
        }
    }*/

    public function roundSpecificDigitAfterPointToUpperBound(string $decimal, int $positionAfterPoint): string
    {
        if ($positionAfterPoint < 0) {
            throw new InvalidPostionAfterPointException();
        }

        $result = $decimal;

        if ('0' === $result && $positionAfterPoint > 0) {
            $result .= '.';
            for ($i = 0; $i < $positionAfterPoint - 1; $i++) { 
                $result .= '0';
            }
        }

        if ($this->checkNumberIsDecimal($decimal)) {
            list($originalWhole, 
                $originalFractional) = $this->splitDecimalIntoWholeAndFractional($decimal);

            if ($positionAfterPoint > 0) {
                $originalFractionalChars = str_split($originalFractional);

                $digitToRound = $originalFractionalChars[$positionAfterPoint-1].'.';
                for ($i = $positionAfterPoint; $i < count($originalFractionalChars); $i++) { 
                    $digitToRound .= $originalFractionalChars[$i];
                }

                $roundedDigit = ceil($digitToRound);

                $stack1 = new \SplStack();
                for ($i=0; $i < $positionAfterPoint-1; $i++) { 
                    $stack1->push($originalFractionalChars[$i]);
                }

                if ($roundedDigit == 10) {
                    $roundedDigit = '0';
                    $plusFlag = true;
                } else {
                    $plusFlag = false;
                }

                $stack2 = new \SplStack();
                for ($i=0; $i < $positionAfterPoint-1; $i++) { 
                    $previous = $stack1->pop();
                    if ($plusFlag) {
                        $previous++;
                    } 
                    if ($previous == 10) {
                        $previous = '0';
                        $plusFlag = true;
                    } else {
                        $plusFlag = false;
                    }
                    $stack2->push($previous);
                }

                $roundedFractional = '';
                for ($i=0; $i < $positionAfterPoint-1; $i++) { 
                    $roundedFractional .= $stack2->pop();
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

    public function checkNumberIsDecimal(string $number): bool
    {
        $isDecimal = true;

        if (1 === preg_match('%\.%', $number)) {
            $parts = explode('.', $number);

            if (count($parts) != 2) {
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
}
