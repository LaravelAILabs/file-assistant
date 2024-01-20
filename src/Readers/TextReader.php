<?php

namespace LaravelAILabs\FileAssistant\Readers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use LaravelAILabs\FileAssistant\Abstracts\FileReaderAbstract;

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
    public function getText(): string
    {
        return $this->limit === null ? $this->reader->get($this->path) : collect($this->reader->lines($this->path)->slice(0, $this->limit))->join(PHP_EOL);
    }
}
