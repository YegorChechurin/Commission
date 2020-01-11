<?php

namespace YegorChechurin\CommissionTask\Controller;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory\CommissionFeeCalculatorFactoryInterface;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\OperationsFileReader;
use YegorChechurin\CommissionTask\Service\DI\Container;

$container = new Container();

$commissionFeeCalculatorFactory = $container->get(CommissionFeeCalculatorFactoryInterface::class);

$operationsFileReader = $container->get(OperationsFileReader::class);

$operations = $operationsFileReader->getOperations($argv[1]);

foreach ($operations as $opr) {
	echo $commissionFeeCalculatorFactory->getCommissionFeeCalculator($opr)->calculateCommissionFee($opr)."\n";
}
