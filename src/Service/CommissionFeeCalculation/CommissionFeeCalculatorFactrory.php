<?php

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CashInCommissionFeeCalculator;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\LegalCashOutCommissionFeeCalculator;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\NaturalCashOutCommissionFeeCalculator;
use YegorChechurin\CommissionTask\Service\DI\Container;
use DI\NotFoundException;
use DI\ContainerBuilder;

use function DI\autowire;

class CommissionFeeCalculatorFactory
{
	private $container;

	private $calculatorPool;

	public function __construct(Container $container)
	{
		$this->container = $container;

		$this->calculatorPool = [];
	}

	public function test()
	{
		$builder = new ContainerBuilder();
        $builder->addDefinitions(
        	['YegorChechurin\\CommissionTask\\TestClass' => autowire()
        ->constructorParameter('test', 'This test is successful!'),]
        );
        $container = $builder->build();
        $container->get('YegorChechurin\\CommissionTask\\TestClass');
	}

	public function getCommissionFeeCalculator(array $operationParameters)//: CommissionFeeCalculatorInterface
	{
		$calculatorClassName = $this->getCalculatorClassName($operationParameters['name'], $operationParameters['user_type']);
		return $this->createCalculator($calculatorClassName); //$this->container->get(NaturalCashOutCommissionFeeCalculator::class);
	}

	private function createCalculator(string $calculatorClassName)
	{
		try {
			$calculator = $this->container->get($calculatorClassName);
			
			//$this->calculatorPool[] = ;
		} catch(NotFoundException $e) {
			list($namespace, $calculatorName) = explode(__NAMESPACE__.'\\', $calculatorClassName);
			var_dump($calculatorName);
			//throw new CommissionFeeCalculatorForThisOperationDoesNotExistException($fileExtension);
		}
	}

	private function getCalculatorClassName(string $operationName, string $customerType): string
	{
		$calculatorName = 'CommissionFeeCalculator';

		$calculatorName = $this->getOperationNamePrefix($operationName).$calculatorName;

		if ('cash_out' === $operationName) {
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
}
