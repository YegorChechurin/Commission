<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\Exception\LogicException;

class CommissionFeeCalculatorForThisOperationDoesNotExistException extends \LogicException
{
    public function __construct(string $operationName, string $userType)
    {
        parent::__construct(
            sprintf(
                'You have not created commission fee calculator for operation "%s" with user type "%s"',
                $operationName,
                $userType
            )
        );
    }
}
