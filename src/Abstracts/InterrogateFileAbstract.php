<?php

namespace LaravelAILabs\FileAssistant\Abstracts;

use LaravelAILabs\FileAssistant\Contracts\InterrogateFileContract;
use LaravelAILabs\FileAssistant\Models\Conversation;
use OpenAI\Client as OpenAIClient;

abstract class InterrogateFileAbstract implements InterrogateFileContract
{
    public function __construct(protected Conversation $conversation, protected OpenAIClient $openAiClient)
    {
    }

    protected function embedPrompt(string $prompt): array
    {
        return $this->openAiClient->embeddings()->create([
            'model' => 'text-embedding-ada-002',
            'input' => $prompt,
        ])->embeddings;
    }
}
