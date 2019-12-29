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

	/** 
	 * @dataProvider operationIsSupportedProvider 
	 */
	public function testCheckOperationIsSupported(string $operationName, string $userType)
	{
		$this->expectException(UnsupportedOperationException::class);

		$this->commissionsManager->getCommissionParameters($operationName, $userType);
	}

	public function operationIsSupportedProvider(): array
	{
		return [
			['WhateverOperation', 'WhateverTypeOfUser'],
		];
	}
}
