<?php

namespace LaravelAILabs\FileAssistant;

use Illuminate\Filesystem\Filesystem;
use LaravelAILabs\FileAssistant\Abstracts\FileReaderAbstract;
use LaravelAILabs\FileAssistant\Contracts\FileContract;
use LaravelAILabs\FileAssistant\Exceptions\UndefinedReaderException;
use LaravelAILabs\FileAssistant\Models\File;
use LaravelAILabs\FileAssistant\Readers\PdfReader;
use LaravelAILabs\FileAssistant\Readers\TextReader;
use LaravelAILabs\FileAssistant\Readers\WordReader;

final class FileWrapper implements FileContract
{
    private FileReaderAbstract $reader;

    public function __construct(private readonly string $path)
    {
        $filesystem = new Filesystem();

        $this->reader = match ($filesystem->mimeType($path)) {
            'application/pdf' => new PdfReader($path),
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword' => new WordReader($path),
            'text/plain' => new TextReader($path),
            default => throw new UndefinedReaderException,
        };
    }

    public function getReader(): FileReaderAbstract
    {
        return $this->reader;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getModel(): File
    {
        return File::firstOrCreate([
            'file_hash' => $this->getHash(),
        ]);
    }

    public function getHash(): string
    {
        return $this->reader->hash();
    }
}
