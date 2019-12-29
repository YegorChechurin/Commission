<?php

namespace YegorChechurin\CommissionTask\Controller;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use YegorChechurin\CommissionTask\Service\DI\Container;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculatorFactory;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\OperationsFileReader;

$container = new Container();

$commissionFeeCalculatorFactory = $container->get(CommissionFeeCalculatorFactory::class);

$operationsFileReader = $container->get(OperationsFileReader::class);

$operations = $operationsFileReader->getOperations($argv[1]);

foreach ($operations as $opr) {
	echo $commissionFeeCalculatorFactory->getCommissionFeeCalculator($opr)->calculateCommissionFee($opr)."\n";
}
