<?php

namespace YegorChechurin\CommissionTask\Service\FileParsing;

use Symfony\Component\Yaml\Yaml;

final class YamlFileParser extends AbstractFileParser
{
	public function __construct()
	{
		$this->correctFileExtension = 'yaml';
	}

	public function parseFile(string $filePath): array
	{
		$this->checkFileExtensionIsCorrect($filePath);
		
		return Yaml::parseFile($filePath);
	}
} 
