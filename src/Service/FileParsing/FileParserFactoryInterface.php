<?php

namespace YegorChechurin\CommissionTask\Service\FileParsing;

interface FileParserFactoryInterface
{
	public function getFileParser(string $fileExtension): FileParserInterface;
}
