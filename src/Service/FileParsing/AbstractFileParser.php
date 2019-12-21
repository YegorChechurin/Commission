<?php

namespace YegorChechurin\CommissionTask\Service\FileParsing;

use YegorChechurin\CommissionTask\Service\FileParsing\Exception\LogicException\FileExtensionIsNotCorrectException;

abstract class AbstractFileParser implements FileParserInterface
{
	protected $correctFileExtension;

	abstract public function parseFile(string $filePath);

	protected function checkFileExtensionIsCorrect(string $filePath): void
	{
		if ($this->correctFileExtension !== pathinfo($filePath, \PATHINFO_EXTENSION)) {
			throw new FileExtensionIsNotCorrectException(pathinfo($filePath, \PATHINFO_EXTENSION), $this->correctFileExtension);
		}
	}
} 
