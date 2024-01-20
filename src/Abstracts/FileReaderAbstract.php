<?php

namespace LaravelAILabs\FileAssistant\Abstracts;

use LaravelAILabs\FileAssistant\Contracts\FileReaderContract;

abstract class FileReaderAbstract implements FileReaderContract
{
    protected ?int $limit = null;

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
}
