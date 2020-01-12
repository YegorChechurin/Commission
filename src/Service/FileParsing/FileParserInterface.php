<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\FileParsing;

interface FileParserInterface
{
    public function parseFile(string $filePath, ?array $parsingParameters): array;
}
