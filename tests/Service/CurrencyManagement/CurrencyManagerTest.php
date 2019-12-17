<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CurrencyManagement;

use PHPUnit\Framework\TestCase;
use YegorChechurin\CommissionTask\Service\CurrencyManagement\CurrencyManager;

class CurrencyManagerTest extends TestCase
{
	/** 
	 * @var CurrencyManager 
	 */
	private $manager;

	public function setUp()
	{
		$this->manager = new CurrencyManager();
	}

	public function testGetConfig()
	{
		var_dump($this->manager->getConfig());

		$this->assertTrue(true);
	}
}