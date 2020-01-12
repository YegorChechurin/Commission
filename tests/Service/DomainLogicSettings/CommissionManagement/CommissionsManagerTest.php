<?php

namespace YegorChechurin\CommissionTask\Tests\Service\DomainLogicSettings\CurrencyManagement;

use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\CommissionsManager;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CommissionManagement\Exception\RuntimeException\UnsupportedOperationException;

class CommissionsManagerTest extends ContainerAwareTestCase
{
	/** 
	 * @var CommissionsManager 
	 */
	private $commissionsManager;

	public function setUp()
	{
		$this->commissionsManager = $this->get(CommissionsManager::class);
	}

	public function testCheckOperationIsSupportedExceptional()
	{
		$this->expectException(UnsupportedOperationException::class);

		$this->commissionsManager->getCommissionParameters('WhateverOperation', 'WhateverTypeOfUser');
	}

    /**
     * @dataProvider operationProvider
     */
    public function testGetCommissionParameters(string $operationName, string $userType, array $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->commissionsManager->getCommissionParameters($operationName, $userType)
        );
    }

	public function operationProvider(): array
	{
		return [
			[
			    'cash_in',
                'legal',
                [
                    'legal' => [
                        'fee_percentage' => 0.0003,
                        'fee_maximum_amount' => 5,
                    ],
                    'natural' => [
                        'fee_percentage' => 0.0003,
                        'fee_maximum_amount' => 5,
                    ],
                ],
            ],
            [
                'cash_in',
                'natural',
                [
                    'legal' => [
                        'fee_percentage' => 0.0003,
                        'fee_maximum_amount' => 5,
                    ],
                    'natural' => [
                        'fee_percentage' => 0.0003,
                        'fee_maximum_amount' => 5,
                    ],
                ],
            ],
            [
                'cash_out',
                'legal',
                [
                    'legal' => [
                        'fee_percentage' => 0.003,
                        'fee_minimum_amount' => 0.5,
                    ],
                    'natural' => [
                        'fee_percentage' => 0.003,
                        'free_of_charge_amount' => 1000,
                        'free_of_charge_number_of_operations' => 3,
                    ],
                ],
            ],
            [
                'cash_out',
                'natural',
                [
                    'legal' => [
                        'fee_percentage' => 0.003,
                        'fee_minimum_amount' => 0.5,
                    ],
                    'natural' => [
                        'fee_percentage' => 0.003,
                        'free_of_charge_amount' => 1000,
                        'free_of_charge_number_of_operations' => 3,
                    ],
                ],
            ],
		];
	}
}
