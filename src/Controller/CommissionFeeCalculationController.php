<?php

namespace YegorChechurin\CommissionTask\Controller;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use DI\Container;
use DI\ContainerBuilder;
use YegorChechurin\CommissionTask\Service\CommissionFeeCalculation\CommissionFeeCalculator;

const CONFIG_FILE_LOCATION = '/config/DI/container.php';

function bootContainer()
{
	$builder = new ContainerBuilder();
    $builder->addDefinitions(
        dirname(__DIR__, 2).CONFIG_FILE_LOCATION
    );

    return $container = $builder->build();
}

$container = bootContainer();

$commissionFeeCalculator = $container->get(CommissionFeeCalculator::class);

$operations = [
                [
                    'date' => '2014-12-31',
                    'user_id' => '4',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1200.00',
                    'currency' => 'EUR',
                ],
                [
                    'date' => '2015-01-01',
                    'user_id' => '4',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1000.00',
                    'currency' => 'EUR',
                ],
                [
                    'date' => '2016-01-05',
                    'user_id' => '4',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1000.00',
                    'currency' => 'EUR',
                ],
                [
                    'date' => '2016-01-05',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_in',
                    'amount' => '200.00',
                    'currency' => 'EUR',
                ],
                [
                    'date' => '2016-01-06',
                    'user_id' => '2',
                    'user_type' => 'legal',
                    'name' => 'cash_out',
                    'amount' => '300.00',
                    'currency' => 'EUR',
                ],
                [
                    'date' => '2016-01-06',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '30000',
                    'currency' => 'JPY',
                ],
                [
                    'date' => '2016-01-07',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1000.00',
                    'currency' => 'EUR',
                ],
                [
                    'date' => '2016-01-07',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '100.00',
                    'currency' => 'USD',
                ],
                [
                    'date' => '2016-01-10',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '100.00',
                    'currency' => 'EUR',
                ],
                [
                    'date' => '2016-01-10',
                    'user_id' => '2',
                    'user_type' => 'legal',
                    'name' => 'cash_in',
                    'amount' => '1000000.00',
                    'currency' => 'EUR',
                ],
                [
                    'date' => '2016-01-10',
                    'user_id' => '3',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '1000.00',
                    'currency' => 'EUR',
                ],
                [
                    'date' => '2016-02-15',
                    'user_id' => '1',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '300.00',
                    'currency' => 'EUR',
                ],
                [
                    'date' => '2016-02-19',
                    'user_id' => '5',
                    'user_type' => 'natural',
                    'name' => 'cash_out',
                    'amount' => '3000000',
                    'currency' => 'JPY',
                ],
        ];

foreach ($operations as $opr) {
	echo $commissionFeeCalculator->calculateCommissionFee($opr)."\n";
}
