<?php

namespace LaravelAILabs\FileAssistant\Contracts;

use Illuminate\Database\Eloquent\Model;
use LaravelAILabs\FileAssistant\InterrogateFile;
use LaravelAILabs\FileAssistant\Models\Conversation;

interface FileAssistantContract
{
    public function from(string $filePath): self;

    public function user(Model $model): self;
    public function conversation(Conversation $conversation): self;

    public function initialize(): InterrogateFile;
}
