<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\Math\Exception\LogicException;

class NumberIsNotDecimalException extends \LogicException
{
    public function __construct(string $number)
    {
        parent::__construct(sprintf('This number "%s" is not decimal', $number));
    }
}
