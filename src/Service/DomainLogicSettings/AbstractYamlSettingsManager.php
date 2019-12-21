<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings;

use YegorChechurin\CommissionTask\Service\DomainLogicSettings\AbstractManager;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractYamlSettingsManager extends AbstractManager
{
	protected $settingsFileExtension = '.yaml';
	
	protected function parseSettingsFile(string $settingsFilePath)
	{
		return Yaml::parseFile($settingsFilePath);
	}
}
