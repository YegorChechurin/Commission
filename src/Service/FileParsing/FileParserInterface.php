<?php

namespace YegorChechurin\CommissionTask\Service\FileParsing;

interface FileParserInterface
{
	public function parseFile(string $filePath, ?array $parsingParameters): array;
}
