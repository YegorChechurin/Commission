<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorInterface;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\CommissionsManager;
use YegorChechurin\CommissionTask\Service\DI\Container;

class CommissionFeeCalculatorFactory
{
	/** 
	 * @var CommissionsManager 
	 */
	private $cm;

	private $container;

	private $calculatorPool;

	public function __construct(CommissionsManager $cm, Container $container)
	{
		$this->cm = $cm;

		$this->container = $container;

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

	private function getCalculatorClassName(string $operationName, string $customerType, array $commissionParameters): string
	{
		$calculatorName = 'CommissionFeeCalculator';

		$calculatorName = $this->getOperationNamePrefix($operationName).$calculatorName;

		if ($commissionParameters['legal'] !== $commissionParameters['natural']) {
			$calculatorName = $this->getUserTypePrefix($customerType).$calculatorName;
		}

		return __NAMESPACE__.'\\'.$calculatorName;
	}

	private function getOperationNamePrefix(string $operationName): string
	{
		list($partOne, $partTwo) = explode('_', $operationName);

		$partOne = ucfirst($partOne);
		$partTwo = ucfirst($partTwo);

		return implode('', [$partOne, $partTwo]);
	}

	private function getUserTypePrefix(string $customerType): string
	{
		return ucfirst($customerType);
	}

	private function hasCalculatorInPool(string $calculatorClassName): bool
	{
		if (array_key_exists($calculatorClassName, $this->calculatorPool)) {
			return true;
		} else {
			return false;
		}
	}

	private function createCalculator(string $calculatorClassName, array $commissionParameters, string $operationName, string $userType)
	{
		if (!$this->container->has($calculatorClassName)) {
			throw new CommissionFeeCalculatorForThisOperationDoesNotExistException($operationName, $userType);
		} 

		$this->calculatorPool[$calculatorClassName] = $this->container->get(
			$calculatorClassName, 
			$this->getCalculatorParameters($commissionParameters[$userType])
		);
	}

	private function getCalculatorParameters(array $commissionParameters): array
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
