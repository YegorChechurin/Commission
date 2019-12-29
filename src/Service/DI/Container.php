<?php

namespace YegorChechurin\CommissionTask\Service\DI;

use DI\Container as ActualContainer;
use DI\ContainerBuilder;

class Container
{
	private const NUMBER_OF_DIR_TO_GO_UP = 3;

	private const CONFIG_FILE_LOCATION = '/config/DI/container.php';
	
	/** 
	 * @var ActualContainer
	 */
	private $container;

	public function __construct()
	{
		$this->bootContainer();
	}

	public function get(string $className)
	{
		return $this->container->get($className);
	}

	private function bootContainer()
	{
		$builder = new ContainerBuilder();
        $builder->addDefinitions(
            dirname(__DIR__, self::NUMBER_OF_DIR_TO_GO_UP).self::CONFIG_FILE_LOCATION
        );

        $this->container = $builder->build();
	}
}
