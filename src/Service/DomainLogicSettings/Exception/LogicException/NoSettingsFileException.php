<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings\Exception\LogicException;

class NoSettingsFileException extends \LogicException
{
    public function __construct(
        string $settingsFileName,
        string $settingFilesFolderPath
    ) {
        parent::__construct(
            sprintf('No settings file found, you have to create %s file in %s', $settingsFileName, $settingFilesFolderPath)
        );
    }
}
