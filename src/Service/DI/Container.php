<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\DI;

use function DI\autowire;
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

    public function has(string $className): bool
    {
        return $this->container->has($className);
    }

    public function get(string $className, ?array $classConstructorParameters = null)
    {
        if ($classConstructorParameters) {
            $definitions = autowire();

            foreach ($classConstructorParameters as $key => $value) {
                $definitions->constructorParameter($key, $value);
            }

            $this->container->set($className, $definitions);
        }

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
