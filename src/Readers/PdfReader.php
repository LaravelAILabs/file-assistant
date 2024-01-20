<?php

namespace LaravelAILabs\FileAssistant\Readers;

use LaravelAILabs\FileAssistant\Abstracts\FileReaderAbstract;
use Smalot\PdfParser\Document;
use Smalot\PdfParser\Parser as PdfParser;

class PdfReader extends FileReaderAbstract
{
	private Document $reader;

	public function __construct(string $path)
	{
		parent::__construct($path);

		$parser = new PdfParser();
		$this->reader = $parser->parseFile($path);
	}

	function getText(): string
	{
		return $this->reader->getText($this->limit);
	}
}
