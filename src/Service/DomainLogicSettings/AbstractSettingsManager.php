<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings;

use YegorChechurin\CommissionTask\Service\FileParsing\FileParserFactoryInterface;
use YegorChechurin\CommissionTask\Service\FileParsing\FileParserInterface;

abstract class AbstractSettingsManager
{
	private const NUM_OF_DIR_TO_GO_UP = 3;

	private const SETTINGS_LOCATION = '/config/DomainLogicSettings';

	protected $settings;

	public function __construct(FileParserFactoryInterface $fileParserFactory)
	{
		$this->settings = $this->getSettings($fileParserFactory);
	}

	private function getSettings(FileParserFactoryInterface $fileParserFactory)
	{
		$settingsFilePath = $this->getSettingsFilePath();
		$settingsFileExtension = pathinfo($settingsFilePath, \PATHINFO_EXTENSION);
		$settingsFileParser = $fileParserFactory->getFileParser($settingsFileExtension);

		return $this->parseSettingsFile($settingsFilePath, $settingsFileParser);
	}

	private function getSettingsFilePath(): string
	{
		$settingsFileName = $this->getSettingsFileName();

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

		return $settingsFilePath;
	}

	private function getSettingsFileName(): string
	{
		$refClass = new \ReflectionClass($this);
		$refClassName = $refClass->getShortName();
		list($settingsName) = explode('Manager', $refClassName);

		return strtolower($settingsName);
	}

	private function getAllSettingFiles(): array
	{
		return scandir($this->getSettingFilesFolderPath());
	}

	private function getSettingFilesFolderPath(): string
	{
		return dirname(__DIR__, self::NUM_OF_DIR_TO_GO_UP).self::SETTINGS_LOCATION;
	}

	private function parseSettingsFile(string $settingsFilePath, FileParserInterface $settingsFileParser): array
	{
		return $settingsFileParser->parseFile($settingsFilePath);
	}
}
