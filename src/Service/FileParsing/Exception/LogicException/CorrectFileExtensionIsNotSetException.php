<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Service\FileParsing\Exception\LogicException;

class CorrectFileExtensionIsNotSetException extends \LogicException
{
    public function __construct(string $fileParserClassName)
    {
        parent::__construct(
            sprintf('You have not set correct file extension for class %s', $fileParserClassName)
        );
    }
}
