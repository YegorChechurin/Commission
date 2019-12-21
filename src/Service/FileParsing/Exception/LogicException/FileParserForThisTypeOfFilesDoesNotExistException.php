<?php

namespace YegorChechurin\CommissionTask\Service\FileParsing\Exception\LogicException;

use YegorChechurin\CommissionTask\Service\FileParsing;
use YegorChechurin\CommissionTask\Service\FileParsing\AbstractFileParser;
use YegorChechurin\CommissionTask\Service\FileParsing\FileParserInterface;

class FileParserForThisTypeOfFilesDoesNotExistException extends \LogicException
{
	private const FILE_PARSING_NAMESPACE = FileParsing::class;

	private const ABSTRACT_FILE_PARSER = AbstractFileParser::class;

	private const FILE_PARSER_INTERFACE = FileParserInterface::class;

	public function __construct(string $fileExtension)
	{
		parent::__construct(
			sprintf('There is no file parser for files with extension "%s", you have to create it in namespace %s either by extending %s or by directly implementing %s', $fileExtension, self::FILE_PARSING_NAMESPACE, self::ABSTRACT_FILE_PARSER, self::FILE_PARSER_INTERFACE)
		);
	}
}
