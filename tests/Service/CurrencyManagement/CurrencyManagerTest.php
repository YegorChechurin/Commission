<?php

namespace YegorChechurin\CommissionTask\Tests\Service\CurrencyManagement;

use PHPUnit\Framework\TestCase;
use YegorChechurin\CommissionTask\Service\CurrencyManagement\CurrencyManager;
use YegorChechurin\CommissionTask\Service\CurrencyManagement\Exception\RuntimeException\UnsupportedCurrencyException;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\CurrenciesManager as CM;

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
		//$this->expectException(UnsupportedCurrencyException::class);
		//var_dump($this->manager->getNumberOfDecimalDigitsOfCurrencySmallestItem('USA'));
		$cm = new CM();
		var_dump($cm->test());

		$this->assertTrue(true);
	}
}