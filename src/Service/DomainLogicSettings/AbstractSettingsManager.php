<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings;

abstract class AbstractSettingsManager
{
	private const NUM_OF_DIR_TO_GO_UP = 3;

	private const SETTINGS_LOCATION = '/config/DomainLogicSettings/';

	private $settingsFileExtension;

	private $settingsFileParser;

	protected $settings;

	public function __construct(string $fileExtension, FileParserInterface $fileParser)
	{
		$this->settingsFileExtension = $fileExtension;

		$this->settingsFileParser = $fileParser;

		$this->settings = $this->getSettings();
	}

	private function getSettings()
	{
		return $this->parseSettingsFile($this->getSettingsFilePath());
	}

	private function parseSettingsFile(string $settingsFilePath)
	{
		$this->settingsFileParser->parseFile($settingsFilePath);
	}

	private function getSettingsFilePath(): string
	{
		$refClass = new \ReflectionClass($this);
		$refClassName = $refClass->getShortName();

		list($settingsName) = explode('Manager', $refClassName);
		$settingsFileName = strtolower($settingsName).$this->settingsFileExtension;
		$settingsFilePath = dirname(__DIR__, self::NUM_OF_DIR_TO_GO_UP).self::SETTINGS_LOCATION.$settingsFileName;

		return $settingsFilePath;
	}

	private function getSettingsFilePathNew()
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
