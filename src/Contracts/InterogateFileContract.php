<?php

namespace LaravelAILabs\FileAssistant\Contracts;

interface InterogateFileContract
{
    public function prompt(string $prompt): string;
}
