<?php

namespace YegorChechurin\CommissionTask\Tests\Service\FileParsing;

use YegorChechurin\CommissionTask\Tests\Service\FileParsing\BaseFileParserTestCase;
use YegorChechurin\CommissionTask\Service\FileParsing\YamlFileParser;

class YamlFileParserTest extends BaseFileParserTestCase
{
	private const TEST_FILE = 'yaml_test.yaml';

	public function setUp()
	{
		$this->fileParserToTest = new YamlFileParser();

		$this->testFilePath = self::FILES_TO_PARSE_DIRECTORY.self::TEST_FILE;
	}

	public function testReadFile()
	{
		$this->assertEquals(
			[
				'test' => ['file_extension' => 'yaml']
			],
			$this->getReadFileResult($this->testFilePath)
		);
	}
}
