<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\Exception\RuntimeException;

class UnsupportedOperationException extends \RuntimeException
{
    public function __construct(string $operationName, string $userType)
    {
        parent::__construct(
            sprintf('Operation with name "%s" for users of type "%s" is not supported, it is not possible to calculate commission fee for this operation', $operationName, $userType)
        );
    }
}
