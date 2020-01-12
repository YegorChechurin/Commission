<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings;

use YegorChechurin\CommissionTask\Service\DomainLogicSettings\Exception\LogicException\NoSettingsFileException;

class SettingFilesInventory
{
    private const NUM_OF_DIR_TO_GO_UP = 3;

    private const SETTINGS_LOCATION = '/config/DomainLogicSettings';

    public function getSettingsFilePath(string $settingsFileName): string
    {
        $allFiles = $this->getAllSettingFiles();

        $settingsFilePath = '';

        foreach ($allFiles as $file) {
            $fileName = pathinfo($file, \PATHINFO_FILENAME);

            if ($fileName === $settingsFileName) {
                $settingsFilePath = $this->getSettingFilesFolderPath().'/'.$file;
                break;
            }
        }

        if (!$settingsFilePath) {
            throw new NoSettingsFileException($settingsFileName, $this->getSettingFilesFolderPath());
        }

        return  $settingsFilePath;
    }

    private function getAllSettingFiles(): array
    {
        return scandir($this->getSettingFilesFolderPath());
    }

    private function getSettingFilesFolderPath(): string
    {
        return dirname(__DIR__, self::NUM_OF_DIR_TO_GO_UP).self::SETTINGS_LOCATION;
    }
}
