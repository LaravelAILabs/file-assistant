<?php

namespace LaravelAILabs\FileAssistant\Readers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use LaravelAILabs\FileAssistant\Abstracts\FileReaderAbstract;
use Illuminate\Filesystem\Filesystem;

class TextReader extends FileReaderAbstract
{
	private Filesystem $reader;

	public function __construct(string $path)
	{
		parent::__construct($path);

		$this->reader = new Filesystem();
	}

	/**
	 * @throws FileNotFoundException
	 */
	function getText(): string
	{
		return null === $this->limit ? $this->reader->get($this->path) : collect($this->reader->lines($this->path)->slice(0, $this->limit))->join(PHP_EOL);
	}
}
