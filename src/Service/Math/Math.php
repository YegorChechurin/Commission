<?php

//declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\Math;

use YegorChechurin\CommissionTask\Service\Math\Exception\LogicException\NumberIsNotDecimalException;
use YegorChechurin\CommissionTask\Service\Math\Exception\RuntimeException\CheckNumberIsDecimalException;

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
