<?php

namespace YegorChechurin\CommissionTask\Tests\Service\FileParsing;

use PHPUnit\Framework\TestCase;
use YegorChechurin\CommissionTask\Service\FileParsing\AbstractFileParser;
use YegorChechurin\CommissionTask\Service\FileParsing\Exception\LogicException\CorrectFileExtensionIsNotSetException;
use YegorChechurin\CommissionTask\Service\FileParsing\Exception\LogicException\FileExtensionIsNotCorrectException;

class AbstractFileParserTest extends TestCase
{
	private $abstractFileParserMock;

	private $testFile;

	public function setUp()
	{
		$this->abstractFileParserMock = $this->getMockBuilder(AbstractFileParser::class)
		    ->getMockForAbstractClass();

		$this->testFile = 'test_file.dummy';
	}

	public function testCheckCorrectFileExtensionIsSet()
	{
		$this->expectException(CorrectFileExtensionIsNotSetException::class);

		$this->abstractFileParserMock->parseFile($this->testFile);
	}

	public function testCheckFileExtensionIsCorrect()
	{
		$this->expectException(FileExtensionIsNotCorrectException::class);

		$mockReflection = new \ReflectionClass($this->abstractFileParserMock);
		$mockPropertyToSet = $mockReflection->getProperty('correctFileExtension');
		$mockPropertyToSet->setAccessible(true);
		$mockPropertyToSet->setValue($this->abstractFileParserMock, 'test');
		$mockPropertyToSet->setAccessible(false);

		$this->abstractFileParserMock->parseFile($this->testFile);
	}
}
