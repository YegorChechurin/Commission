<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\FileParsing;

class CsvFileParser extends AbstractFileParser
{
    private const CORRECT_FILE_EXTENSION = 'csv';

    public function __construct()
    {
        $this->correctFileExtension = self::CORRECT_FILE_EXTENSION;
    }

    protected function readFile(string $filePath, ?array $readKeys = null): array
    {
        $handle = fopen($filePath, 'r');

        $readResult = [];

        while ($values = fgetcsv($handle)) {
            if ($readKeys) {
                $readResult[] = array_combine($readKeys, $values);
            } else {
                $readResult[] = $values;
            }
        }

        return $readResult;
    }
}
