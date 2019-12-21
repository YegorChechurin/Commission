<?php

namespace YegorChechurin\CommissionTask\Service\FileParsing;

class FileParserFactory
{
	private $fileParserPool;

	public function __construct()
	{
		$this->fileParserPool = [];
	}

	public function getFileParser(string $fileExtension): FileParserInterface
	{
		if (!$this->hasFileParserInPool($fileExtension)) {
			$this->createFileParser($fileExtension);
		}

		return $this->fileParserPool[$fileExtension];
	}

	private function hasFileParserInPool(string $fileExtension): bool
	{
		if (array_key_exists($fileExtension, $this->fileParserPool)) {
			return true;
		} else {
			return false;
		}
		
	}

	private function createFileParser(string $fileExtension): void
	{
		try {
			if (!array_key_exists($fileExtension, $this->fileParserPool)) {
				$fileParserClassName = __NAMESPACE__.ucfirst($fileExtension).'FileParser';
				$fileParserReflection = new \ReflectionClass($fileParserClassName);

				$this->fileParserPool[$fileExtension] = $fileParserReflection->newInstance();
			}
		} catch(\ReflectionException $e) {
			throw new FileParserForThisTypeOfFilesDoesNotExistException($fileExtension);
		}
	}
}
