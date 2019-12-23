<?php

namespace YegorChechurin\CommissionTask\Tests;

use PHPUnit\Framework\TestCase;
use DI\Container;
use DI\ContainerBuilder;

abstract class ContainerAwareTestCase extends TestCase
{
	private const CONFIG_FILE_LOCATION = '/config/DI/container.php';
	
	/** 
	 * @var Container 
	 */
	private $container;

	protected function get(string $className)
	{
		if (!($this->container instanceof Container)) {
			$this->bootContainer();
		}

		return $this->container->get($className);
	}

	private function bootContainer()
	{
		$builder = new ContainerBuilder();
        $builder->addDefinitions(
            dirname(__DIR__).self::CONFIG_FILE_LOCATION
        );

        $this->container = $builder->build();
	}
}
