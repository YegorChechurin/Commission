<?php

namespace YegorChechurin\CommissionTask\Service\FileParsing;

use Symfony\Component\Yaml\Yaml;

final class YamlFileParser extends AbstractFileParser
{
	private const CORRECT_FILE_EXTENSION = 'yaml';

	public function __construct()
	{
		$this->correctFileExtension = self::CORRECT_FILE_EXTENSION;
	}

	protected function readFile(string $filePath, ?array $readingParameters = null): array
	{	
		return Yaml::parseFile($filePath);
	}
} 
