<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings;

use Symfony\Component\Yaml\Yaml;

class YamlSettingsGetter
{
	private const NUM_OF_DIR_TO_GO_UP = 3;

	public static function getSettings(string $fileName)
	{
		return Yaml::parseFile(dirname(__DIR__, self::NUM_OF_DIR_TO_GO_UP).'/config/DomainLogicSettings/'.$fileName);
	}
}
