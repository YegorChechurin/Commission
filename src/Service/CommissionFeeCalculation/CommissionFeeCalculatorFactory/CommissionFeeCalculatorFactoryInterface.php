<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorInterface;

interface CommissionFeeCalculatorFactoryInterface
{
    public function getCommissionFeeCalculator(array $operationParameters): CommissionFeeCalculatorInterface;
}
