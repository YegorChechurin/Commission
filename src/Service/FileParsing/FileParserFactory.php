<?php

namespace YegorChechurin\CommissionTask\Service\FileParsing;

class FileParserFactory
{
	private $fileParserPool;

	public function createFileParser(string $fileExtension): FileParserInterface
	{
		$fileParserClassName = __NAMESPACE__.ucfirst($fileExtension).'FileParser';

		try {
			return (new \ReflectionClass($fileParserClassName))->newInstance();
		} catch(\ReflectionException) {
			throw new FileParserForThisTypeOfFilesDoesNotExistException($fileExtension);
		}
	}
}
