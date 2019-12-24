<?php

namespace YegorChechurin\CommissionTask\Tests\Service\DomainLogicSettings;

use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\AbstractSettingsManager;
use YegorChechurin\CommissionTask\Service\FileParsing\FileParserFactoryInterface;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\Exception\LogicException\NoSettingsFileException;

class AbstractSettingsManagerTest extends ContainerAwareTestCase
{
	public function testGetSettingsFileNameAndPath()
	{
		$mockClassName = 'FakeManager';
		list($mockSettingsFileName) = explode('Manager', $mockClassName);
		$mockSettingsFileName = strtolower($mockSettingsFileName);

		$this->expectException(NoSettingsFileException::class);
		$this->expectExceptionMessage($mockSettingsFileName);

		$mock = $this->getMockBuilder(AbstractSettingsManager::class)
		    ->setMockClassName($mockClassName)
		    ->setConstructorArgs([$this->get(FileParserFactoryInterface::class)])
		    ->getMockForAbstractClass();
	}
}
