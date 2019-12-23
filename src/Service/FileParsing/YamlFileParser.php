<?php

namespace YegorChechurin\CommissionTask\Service\FileParsing;

use Symfony\Component\Yaml\Yaml;

class YamlFileParser extends AbstractFileParser
{
	private const CORRECT_FILE_EXTENSION = 'yaml';

	public function __construct()
	{
		$this->correctFileExtension = self::CORRECT_FILE_EXTENSION;
	}

	protected function readFile(string $filePath): array
	{	
		return Yaml::parseFile($filePath);
	}
} 
