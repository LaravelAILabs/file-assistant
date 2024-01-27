<?php

namespace LaravelAILabs\FileAssistant\Contracts;

use Illuminate\Database\Eloquent\Model;
use LaravelAILabs\FileAssistant\InterrogateFile;
use LaravelAILabs\FileAssistant\Models\Conversation;

interface FileAssistantContract
{
    public function addFile(string $filePath): self;

    public function setUser(Model $model): self;

    public function getUser(): ?Model;

    public function setConversation(Conversation $conversation): self;

    public function getConversation(): ?Conversation;

    public function initialize(): InterrogateFile;
}
