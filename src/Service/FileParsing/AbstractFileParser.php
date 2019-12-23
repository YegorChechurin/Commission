<?php

namespace YegorChechurin\CommissionTask\Service\FileParsing;

use YegorChechurin\CommissionTask\Service\FileParsing\Exception\LogicException\CorrectFileExtensionIsNotSetException;
use YegorChechurin\CommissionTask\Service\FileParsing\Exception\LogicException\FileExtensionIsNotCorrectException;

abstract class AbstractFileParser implements FileParserInterface
{
	protected $correctFileExtension;

	abstract protected function readFile(string $filePath, ?array $readingParameters = null): array;

	public function parseFile(string $filePath, ?array $parsingParameters = null): array
	{
		$this->checkCorrectFileExtensionIsSet();
		$this->checkFileExtensionIsCorrect($filePath);

		return $this->readFile($filePath, $parsingParameters);
	}

	protected function checkCorrectFileExtensionIsSet(): void
	{
		if (!$this->correctFileExtension) {
			$fileParserClassName = (new \ReflectionClass($this))->getName();
			
			throw new CorrectFileExtensionIsNotSetException($fileParserClassName);
		}
	}

	protected function checkFileExtensionIsCorrect(string $filePath): void
	{
		if ($this->correctFileExtension !== pathinfo($filePath, \PATHINFO_EXTENSION)) {
			throw new FileExtensionIsNotCorrectException(pathinfo($filePath, \PATHINFO_EXTENSION), $this->correctFileExtension);
		}
	}
} 
