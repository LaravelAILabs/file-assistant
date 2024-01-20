<?php

namespace LaravelAILabs\FileAssistant;

use Illuminate\Filesystem\Filesystem;
use LaravelAILabs\FileAssistant\Abstracts\FileReaderAbstract;
use LaravelAILabs\FileAssistant\Exceptions\UndefinedReaderException;
use LaravelAILabs\FileAssistant\Readers\PdfReader;
use LaravelAILabs\FileAssistant\Readers\TextReader;
use LaravelAILabs\FileAssistant\Readers\WordReader;

class FileAssistant
{
    private Filesystem $filesystem;

    private FileReaderAbstract $reader;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    public function from($path)
    {
        // instantiate the reader
        $this->reader = match ($this->filesystem->mimeType($path)) {
            'application/pdf' => new PdfReader($path),
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword' => new WordReader($path),
            'text/plain' => new TextReader($path),
            default => throw new UndefinedReaderException,
        };
    }
}
