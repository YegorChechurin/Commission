<?php

namespace YegorChechurin\CommissionTask\Tests\Service\FileParsing;

use PHPUnit\Framework\TestCase;

abstract class BaseFileParserTestCase extends TestCase
{
	protected const FILES_TO_PARSE_DIRECTORY = __DIR__.'/FilesToParse/';

	protected $fileParserToTest;

	protected $testFilePath;

	protected function getReadFileResult(string $filePath)
	{
		$parserReflection = new \ReflectionClass($this->fileParserToTest);
		$readFileMethodReflection = $parserReflection->getMethod('readFile');
		$readFileMethodReflection->setAccessible(true);

		$fileContents = $readFileMethodReflection->invokeArgs(
			$this->fileParserToTest, [$filePath]
		);

		$readFileMethodReflection->setAccessible(false);

		return $fileContents;
	}
}
