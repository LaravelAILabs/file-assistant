<?php

namespace LaravelAILabs\FileAssistant\Contracts;

use LaravelAILabs\FileAssistant\Models\Conversation;

interface InterrogateFileContract
{
    public function prompt(string $prompt): string;
    public function getConversation(): Conversation;
}
