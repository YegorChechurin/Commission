<?php

namespace YegorChechurin\CommissionTask\Tests;

use PHPUnit\Framework\TestCase;
use DI\ContainerBuilder;

class ContainerAwareTestCase extends TestCase
{
	/** 
	 * @var DI\Container 
	 */
	protected $container;

	public function __construct()
	{
		parent::__construct();

		$builder = new ContainerBuilder();
        $builder->addDefinitions(
            dirname(__DIR__, 3).'/config/DI/container.php'
        );

        $this->container = $builder->build();
	}
}
