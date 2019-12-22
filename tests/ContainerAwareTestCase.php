<?php

namespace YegorChechurin\CommissionTask\Tests;

use PHPUnit\Framework\TestCase;
use DI\ContainerBuilder;

class ContainerAwareTestCase extends TestCase
{
	private const CONFIG_FILE_LOCATION = '/config/DI/container.php';
	
	/** 
	 * @var DI\Container 
	 */
	protected $container;

	protected function bootContainer()
	{
		$builder = new ContainerBuilder();
        $builder->addDefinitions(
            dirname(__DIR__).self::CONFIG_FILE_LOCATION
        );

        $this->container = $builder->build();
	}
}
