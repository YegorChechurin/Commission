<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorInterface;
use YegorChechurin\CommissionTask\Service\DI\Container;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\CommissionsManager;

class SingletonCommissionFeeCalculatorFactory extends AbstractCommissionFeeCalculatorFactory
{
    private $calculatorPool;

    public function __construct(CommissionsManager $cm, Container $container)
    {
        parent::__construct($cm, $container);

        $this->calculatorPool = [];
    }

    public function getCommissionFeeCalculator(array $operationParameters): CommissionFeeCalculatorInterface
    {
        $commissionParams = $this->cm->getCommissionParameters($operationParameters['name'], $operationParameters['user_type']);

        $calculatorClassName = $this->getCalculatorClassName($operationParameters['name'], $operationParameters['user_type'], $commissionParams);

        if (!$this->hasCalculatorInPool($calculatorClassName)) {
            $this->createCalculator($calculatorClassName, $commissionParams, $operationParameters['name'], $operationParameters['user_type']);
        }

        return $this->calculatorPool[$calculatorClassName];
    }

    private function hasCalculatorInPool(string $calculatorClassName): bool
    {
        if (array_key_exists($calculatorClassName, $this->calculatorPool)) {
            return true;
        } else {
            return false;
        }
    }

    protected function createCalculator(string $calculatorClassName, array $commissionParameters, string $operationName, string $userType)
    {
        $this->calculatorPool[$calculatorClassName] = parent::createCalculator($calculatorClassName, $commissionParameters, $operationName, $userType);
    }
}
