<?php

namespace LaravelAILabs\FileAssistant\Contracts;

use Illuminate\Database\Eloquent\Model;
use LaravelAILabs\FileAssistant\InterrogateFile;
use LaravelAILabs\FileAssistant\Models\Conversation;

interface FileAssistantContract
{
    public function addFile(string $filePath): self;

    public function setUser(Model $model): self;

    public function setConversation(Conversation|int|null $conversation): self;

    public function initialize(): InterrogateFile;
}
