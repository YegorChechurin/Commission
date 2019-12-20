<?php

use Symfony\Component\Yaml\Yaml;

abstract class AbstractManager
{
	private const NUM_OF_DIR_TO_GO_UP = 3;

	private function getSettings()
	{
		$reflection = new \ReflectionClass($this);

		$configFileName = strtolower($reflection->getName()).'s.yaml';

		$filePath = dirname(__DIR__, self::NUM_OF_DIR_TO_GO_UP).'/config/DomainLogicSettings/'.$configFileName;

		return Yaml::parseFile($filePath);
	}
}
