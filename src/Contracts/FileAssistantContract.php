<?php

namespace LaravelAILabs\FileAssistant\Contracts;

interface FileAssistantContract
{
    public function from(string $path): self;

    public function query(string $query): string;
}
