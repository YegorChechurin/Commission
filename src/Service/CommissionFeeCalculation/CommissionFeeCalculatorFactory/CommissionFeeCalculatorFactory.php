<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorInterface;

class CommissionFeeCalculatorFactory extends AbstractCommissionFeeCalculatorFactory
{
    public function getCommissionFeeCalculator(array $operationParameters): CommissionFeeCalculatorInterface
    {
        $commissionParams = $this->cm->getCommissionParameters($operationParameters['name'], $operationParameters['user_type']);

        $calculatorClassName = $this->getCalculatorClassName($operationParameters['name'], $operationParameters['user_type'], $commissionParams);

        return $this->createCalculator($calculatorClassName, $commissionParams, $operationParameters['name'], $operationParameters['user_type']);
    }
}
