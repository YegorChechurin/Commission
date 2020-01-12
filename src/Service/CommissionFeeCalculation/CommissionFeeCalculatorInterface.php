<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

interface CommissionFeeCalculatorInterface
{
    public function calculateCommissionFee(array $operationParameters): string;
}
