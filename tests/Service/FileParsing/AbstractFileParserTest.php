<?php

namespace YegorChechurin\CommissionTask\Tests\Service\FileParsing;

use PHPUnit\Framework\TestCase;
use YegorChechurin\CommissionTask\Service\FileParsing\AbstractFileParser;
use YegorChechurin\CommissionTask\Service\FileParsing\Exception\LogicException\CorrectFileExtensionIsNotSetException;
use YegorChechurin\CommissionTask\Service\FileParsing\Exception\LogicException\FileExtensionIsNotCorrectException;

class AbstractFileParserTest extends TestCase
{
	private $testFile;

	public function setUp()
	{
		$this->testFile = 'test_file.dummy';
	}

	public function testCheckCorrectFileExtensionIsSet()
	{
		$this->expectException(CorrectFileExtensionIsNotSetException::class);

		$abstractFileParserMock = $this->getMockBuilder(AbstractFileParser::class)
		    ->getMockForAbstractClass();

		$abstractFileParserMock->parseFile($this->testFile);
	}

	public function testCheckFileExtensionIsCorrect()
	{
		$this->expectException(FileExtensionIsNotCorrectException::class);

		$abstractFileParserMock = $this->getMockBuilder(AbstractFileParser::class)
		    ->getMockForAbstractClass();

		$mockReflection = new \ReflectionClass($abstractFileParserMock);
		$mockPropertyToSet = $mockReflection->getProperty('correctFileExtension');
		$mockPropertyToSet->setAccessible(true);
		$mockPropertyToSet->setValue($abstractFileParserMock, 'test');
		$mockPropertyToSet->setAccessible(false);

		$abstractFileParserMock->parseFile($this->testFile);
	}
}
