<?php

namespace LaravelAILabs\FileAssistant\Contracts;

interface InterogateFileContract
{
    public function ask(string $prompt): string;
}
