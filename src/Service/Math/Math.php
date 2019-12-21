<?php

//declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\Math;

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

    public function checkNumberIsDecimal($number): bool
    {
        if (1 === preg_match('%\.%', $number)) {
            return true;
        } elseif ((int)0 === preg_match('%\.%', $number)) {
            return false;
        } else {
            throw new CheckNumberIsDecimalException((string) $number);
        }
    }

    public function splitDecimalIntoWholeAndFractional($decimal): array
    {
        if ($this->checkNumberIsDecimal($decimal)) {
            return explode('.', strval($decimal));
        } else {
            throw new NumberIsNotDecimalException((string) $decimal);
        }
    }
}
