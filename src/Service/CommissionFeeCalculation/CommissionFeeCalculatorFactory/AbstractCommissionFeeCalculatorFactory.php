<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\Exception\LogicException\CommissionFeeCalculatorForThisOperationDoesNotExistException;
use YegorChechurin\CommissionTask\Service\DI\Container;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\CommissionsManager;

abstract class AbstractCommissionFeeCalculatorFactory implements CommissionFeeCalculatorFactoryInterface
{
    /**
     * @var CommissionsManager
     */
    protected $cm;

    /**
     * @var Container
     */
    protected $container;

    abstract public function getCommissionFeeCalculator(array $operationParameters): CommissionFeeCalculatorInterface;

    public function __construct(CommissionsManager $cm, Container $container)
    {
        $this->cm = $cm;

        $this->container = $container;
    }

    protected function getCalculatorClassName(string $operationName, string $customerType, array $commissionParameters): string
    {
        $calculatorName = 'CommissionFeeCalculator';

        $calculatorName = $this->getOperationNamePrefix($operationName).$calculatorName;

        if ($commissionParameters['legal'] !== $commissionParameters['natural']) {
            $calculatorName = $this->getUserTypePrefix($customerType).$calculatorName;
        }

        return 'YegorChechurin\\CommissionTask\\Service\\CommissionFeeCalculation\\'.$calculatorName;
    }

    protected function getOperationNamePrefix(string $operationName): string
    {
        list($partOne, $partTwo) = explode('_', $operationName);

        $partOne = ucfirst($partOne);
        $partTwo = ucfirst($partTwo);

        return implode('', [$partOne, $partTwo]);
    }

    protected function getUserTypePrefix(string $customerType): string
    {
        return ucfirst($customerType);
    }

    protected function createCalculator(string $calculatorClassName, array $commissionParameters, string $operationName, string $userType)
    {
        if (!$this->container->has($calculatorClassName)) {
            throw new CommissionFeeCalculatorForThisOperationDoesNotExistException($operationName, $userType);
        }

        return $this->container->get(
            $calculatorClassName,
            $this->getCalculatorParameters($commissionParameters[$userType])
        );
    }

    protected function getCalculatorParameters(array $commissionParameters): array
    {
        $parameterNamesSnakeCase = array_keys($commissionParameters);

        $parameterNamesCamelCase = [];
        for ($i = 0; $i < count($parameterNamesSnakeCase); $i++) {
            $parts = explode('_', $parameterNamesSnakeCase[$i]);

            for ($j = 1; $j < count($parts); $j++) {
                $parts[$j] = ucfirst($parts[$j]);
            }

            $parameterNamesCamelCase[$i] = implode('', $parts);
        }

        return array_combine($parameterNamesCamelCase, array_values($commissionParameters));
    }
}
