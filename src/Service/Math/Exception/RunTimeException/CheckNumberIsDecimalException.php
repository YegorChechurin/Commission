<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\Math\Exception\RuntimeException;

class CheckNumberIsDecimalException extends \RuntimeException
{
    public function __construct(string $number)
    {
        parent::__construct(sprintf('An error occured when determining whether "%s" is a decimal number or not', $number));
    }
}
