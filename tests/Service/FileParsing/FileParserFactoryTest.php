<?php

namespace YegorChechurin\CommissionTask\Tests\Service\FileParsing;

use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;
use YegorChechurin\CommissionTask\Service\FileParsing\FileParserFactory;
use YegorChechurin\CommissionTask\Service\FileParsing\YamlFileParser;
use YegorChechurin\CommissionTask\Service\FileParsing\Exception\LogicException\FileParserForThisTypeOfFilesDoesNotExistException;

class FileParserFactoryTest extends ContainerAwareTestCase
{
	/**
	 * @var FileParserFactory
	 */
	private $fileParserFactory;

	public function setUp()
	{
		$this->fileParserFactory = $this->get(FileParserFactory::class);
	}

	public function testGetFileParser()
	{
		$yamlFileParser = $this->fileParserFactory->getFileParser('yaml');

		$this->assertInstanceOf(YamlFileParser::class, $yamlFileParser);

		$this->assertTrue(
			$yamlFileParser === $this->fileParserFactory->getFileParser('yaml')
		);

		$this->expectException(FileParserForThisTypeOfFilesDoesNotExistException::class);

		$fakeFileParser = $this->fileParserFactory->getFileParser('fake');
	}
}
