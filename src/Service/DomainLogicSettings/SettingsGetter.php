<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings;

use Symfony\Component\Yaml\Yaml;

class SettingsGetter
{
	private const NUM_OF_DIR_TO_GO_UP = 3;

	public static function getSettings(string $fileName)
	{
		$filePath = dirname(__DIR__, self::NUM_OF_DIR_TO_GO_UP).'/config/DomainLogicSettings/'.$fileName.'yaml';

		return Yaml::parseFile($filePath);
	}
}
