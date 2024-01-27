<?php

namespace LaravelAILabs\FileAssistant\Contracts;

use LaravelAILabs\FileAssistant\Abstracts\FileReaderAbstract;
use LaravelAILabs\FileAssistant\Models\File;

interface FileContract
{
    public function getReader(): FileReaderAbstract;

    public function getPath(): string;

    public function getModel(): File;

    public function getHash(): string;
}
