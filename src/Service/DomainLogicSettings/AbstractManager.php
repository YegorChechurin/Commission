<?php

namespace YegorChechurin\CommissionTask\Service\DomainLogicSettings;

use Symfony\Component\Yaml\Yaml;

abstract class AbstractManager
{
	private const NUM_OF_DIR_TO_GO_UP = 3;

	private const SETTINGS_LOCATION = '/config/DomainLogicSettings/';

	protected $settingsFileExtension;

	protected $settings;

	abstract protected function parseSettingsFile(string $settingsFilePath);

	public function __construct()
	{
		$this->settings = $this->getSettings();
	}

	private function getSettings()
	{
		return $this->parseSettingsFile($this->getSettingsFilePath());
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
}
