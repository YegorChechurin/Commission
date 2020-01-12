<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings;

use YegorChechurin\CommissionTask\Service\FileParsing\FileParserFactoryInterface;

class SettingsFetcher
{
    /**
     * @var SettingFilesInventory
     */
    private $settingFilesInventory;

    /**
     * @var FileParserFactoryInterface
     */
    private $fileParserFactory;

    public function __construct(SettingFilesInventory $settingFilesInventory, FileParserFactoryInterface $fileParserFactory)
    {
        $this->settingFilesInventory = $settingFilesInventory;

        $this->fileParserFactory = $fileParserFactory;
    }

    public function fetchSettings($settingsManager): array
    {
        $settingsFileName = $this->getSettingsFileName($settingsManager);
        $settingsFilePath = $this->settingFilesInventory->getSettingsFilePath($settingsFileName);
        $settingsFileExtension = pathinfo($settingsFilePath, \PATHINFO_EXTENSION);
        $settingsFileParser = $this->fileParserFactory->getFileParser($settingsFileExtension);

        return $settingsFileParser->parseFile($settingsFilePath);
    }

    private function getSettingsFileName($settingsManager): string
    {
        $refClass = new \ReflectionClass($settingsManager);
        $refClassName = $refClass->getShortName();
        list($settingsName) = explode('Manager', $refClassName);

        return strtolower($settingsName);
    }
}
