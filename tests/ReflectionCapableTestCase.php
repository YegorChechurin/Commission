<?php

namespace YegorChechurin\CommissionTask\Tests;

use PHPUnit\Framework\TestCase;

abstract class ReflectionCapableTestCase extends TestCase
{
	protected function setNonPublicProperty($object, string $propertyName, $propertyValue)
	{
		$reflection = new \ReflectionClass($object);
		$propertyToSet = $reflection->getProperty($propertyName);
		$$propertyToSet->setAccessible(true);
		$propertyToSet->setValue($object, $propertyValue);
		$propertyToSet->setAccessible(false);
	}

	protected function executeNonPublicMethod($object, string $methodName, ?array $methodArguments, bool $returnExecutionResult = false)
	{
		$reflection = new \ReflectionClass($object);
		$methodToExecute = $reflection->getMethod($methodName);
		$methodToExecute->setAccessible(true);

		if ($methodArguments) {
			$executionResult = $methodToExecute->invokeArgs(
			    $object, $methodArguments
		    );
		} else {
			$executionResult = $methodToExecute->invoke($object);
		}

		//$executionResult = $methodToExecute->invoke($object, $methodArguments);

		$methodToExecute->setAccessible(false);

		if ($returnExecutionResult) {
			return $executionResult;
		}
	}
}
