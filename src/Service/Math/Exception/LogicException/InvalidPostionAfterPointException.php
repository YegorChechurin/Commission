<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\Math\Exception\LogicException;

class InvalidPostionAfterPointException extends \LogicException
{
    public function __construct()
    {
        parent::__construct(
            'Position of digit after point cannot be negative, it can be either positive or zero'
        );
    }
}
