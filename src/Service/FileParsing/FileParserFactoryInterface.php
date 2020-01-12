<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\FileParsing;

interface FileParserFactoryInterface
{
    public function getFileParser(string $fileExtension): FileParserInterface;
}
