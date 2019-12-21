<?php

namespace YegorChechurin\CommissionTask\Service\FileParsing\Exception\LogicException;

class FileExtensionIsNotCorrectException extends \LogicException
{
	public function __construct()
	{
		parent::__construct($givenFileExtension, $correctFileExtension)
		{
			sprintf('File with "%s" extension is given, while correct extension is "%s"', $givenFileExtension, $correctFileExtension);
		}
	}
}
