<?php

namespace YegorChechurin\CommissionTask\Tests\Service\FileParsing;

use PHPUnit\Framework\TestCase;

abstract class BaseFileParserTest extends TestCase
{
	protected const FILES_TO_PARSE_DIRECTORY = __DIR__.'/FilesToParse/';

	protected $fileParserToTest;

	protected $testFilePath;

	protected function getReadFileResult(string $filePath, array $readingParameters = null)
	{
		$parserReflection = new \ReflectionClass($this->fileParserToTest);
		$readFileMethodReflection = $parserReflection->getMethod('readFile');
		$readFileMethodReflection->setAccessible(true);

		$fileContents = $readFileMethodReflection->invokeArgs(
			$this->fileParserToTest, 
			[$filePath, $readingParameters]
		);
		
		$readFileMethodReflection->setAccessible(false);

		return $fileContents;
	}
}
