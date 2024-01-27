<?php

namespace LaravelAILabs\FileAssistant;

use LaravelAILabs\FileAssistant\Contracts\InterogateFileContract;
use LaravelAILabs\FileAssistant\Models\Conversation;
use OpenAI\Client as OpenAIClient;

class InterogateFile implements InterogateFileContract
{
    public function __construct(private Conversation $conversation, private OpenAIClient $openAiClient)
    {
    }

    public function ask(string $query): string
    {
        $response = $this->openAiClient->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                'role' => 'user',
                'content' => $query,
            ],
        ]);

        return $response->choices[0]->message->content ?? '';
    }
}
