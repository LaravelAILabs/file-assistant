<?php

namespace LaravelAILabs\FileAssistant\Contracts;

use Illuminate\Database\Eloquent\Model;
use LaravelAILabs\FileAssistant\InterogateFile;

interface FileAssistantContract
{
    public function from(string $filePath): self;

    public function user(Model $model): self;

    public function initialize(): InterogateFile;
}
