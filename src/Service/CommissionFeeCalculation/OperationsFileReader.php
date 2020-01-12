<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\CommissionFeeCalculation;

use YegorChechurin\CommissionTask\Service\FileParsing\CsvFileParser;

class OperationsFileReader
{
    private const OPERATION_FIELDS = [
                'date',
                'user_id',
                'user_type',
                'name',
                'amount',
                'currency',
            ];

    private $csvParser;

    public function __construct(CsvFileParser $csvParser)
    {
        $this->csvParser = $csvParser;
    }

    public function getOperations(string $operationsFilePath): array
    {
        $operations = $this->csvParser->parseFile(
            $operationsFilePath,
            self::OPERATION_FIELDS
        );

        return $operations;
    }
}
