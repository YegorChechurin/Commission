<?php

namespace YegorChechurin\CommissionTask\Tests\Service\DomainLogicSettings;

use YegorChechurin\CommissionTask\Service\DomainLogicSettings\Exception\LogicException\NoSettingsFileException;
use YegorChechurin\CommissionTask\Service\DomainLogicSettings\SettingFilesInventory;
use YegorChechurin\CommissionTask\Tests\ContainerAwareTestCase;

class SettingFilesInventoryTest extends ContainerAwareTestCase
{
    /**
     * @var SettingFilesInventory
     */
    private $settingFilesInventory;

    public function setUp()
    {
        $this->settingFilesInventory = $this->get(SettingFilesInventory::class);
    }

    public function testGetSettingsFilePathExceptional()
    {
        $this->expectException(NoSettingsFileException::class);

        $this->settingFilesInventory->getSettingsFilePath('some_fake_name');
    }

    /**
     * @dataProvider settingsFileNameProvider
     */
    public function testGetSettingsFilePath(string $settingsFileName, string $settingsFile)
    {
        $expectation = $this->getSettingFilesFolderPath().$settingsFile;

        $this->assertEquals(
            $expectation,
            $this->settingFilesInventory->getSettingsFilePath($settingsFileName)
        );
    }

    public function settingsFileNameProvider()
    {
        return [
            [
                'commissions',
                '/commissions.yaml'
            ],
            [
                'currencies',
                '/currencies.yaml'
            ],
        ];
    }

    private function getSettingFilesFolderPath(): string
    {
        $reflection = new \ReflectionClass($this->settingFilesInventory);
        $methodReflection = $reflection->getMethod('getSettingFilesFolderPath');
        $methodReflection->setAccessible(true);

        $settingFilesFolderPath = $methodReflection->invoke($this->settingFilesInventory);

        $methodReflection->setAccessible(false);

        return $settingFilesFolderPath;
    }
}
