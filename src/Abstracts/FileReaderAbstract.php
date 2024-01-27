<?php

namespace LaravelAILabs\FileAssistant\Abstracts;

use LaravelAILabs\FileAssistant\Contracts\FileReaderContract;

abstract class FileReaderAbstract implements FileReaderContract
{
    protected ?int $limit = null;

    protected ?string $hash = null;

    public function __construct(protected string $path)
    {
    }

    /**
     * Limits a file reader to pages/lines
     * depending on the reader type
     *
     *
     * @return $this
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Generates a hash value for the current file
     *
     * @return string The hash value
     */
    public function hash(): string
    {
        return $this->hash ??= hash_file('sha256', $this->path);
    }
}
