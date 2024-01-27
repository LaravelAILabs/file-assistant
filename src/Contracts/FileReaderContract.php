<?php

namespace LaravelAILabs\FileAssistant\Contracts;

interface FileReaderContract
{
    public function limit(int $limit): self;

    public function getText(): string;

    public function hash(): string;
}
