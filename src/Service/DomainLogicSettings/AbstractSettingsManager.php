<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings;

abstract class AbstractSettingsManager
{
	private const NUM_OF_DIR_TO_GO_UP = 3;

	private const SETTINGS_LOCATION = '/config/DomainLogicSettings/';

	protected $settings;

	public function __construct(FileParserFactory $fileParserFactory)
	{
		$this->settings = $this->getSettings($fileParserFactory);
	}

	private function getSettings(FileParserFactory $fileParserFactory)
	{
		return $this->parseSettingsFile($this->getSettingsFilePath(), $fileParserFactory);
	}

	private function parseSettingsFile(string $settingsFilePath, FileParserFactory $fileParserFactory)
	{
		$settingsFileExtension = pathinfo($settingsFilePath, \PATHINFO_EXTENSION);
		$settingsFileParser = $fileParserFactory->getFileParser($settingsFileExtension);

		return $settingsFileParser->parseFile($settingsFilePath);
	}

	private function getSettingsFilePath(): string
	{
		$allFiles = $this->getAllSettingFiles();

		$settingsFilePath = '';

		foreach ($allFiles as $file) {
			# code...
		}
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
