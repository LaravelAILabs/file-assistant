<?php

namespace LaravelAILabs\FileAssistant;

use AdrianTanase\VectorStore\Facades\VectorStore;
use AdrianTanase\VectorStore\Providers\Pinecone\Requests\PineconeQueryRequest;
use Illuminate\Support\Facades\Config;
use LaravelAILabs\FileAssistant\Abstracts\InterrogateFileAbstract;
use LaravelAILabs\FileAssistant\Enums\RoleType;
use LaravelAILabs\FileAssistant\Models\File;
use LaravelAILabs\FileAssistant\Models\Message;

final class InterrogateFile extends InterrogateFileAbstract
{
    public function prompt(string $prompt): string
    {
        $embedding = $this->embedPrompt($prompt);

        // query the vector database for the embedding results
        $responses = $this->conversation->files->map(function (File $file) use ($embedding) {
            $vectorDatabaseResponse = VectorStore::dataset(Config::get('file-assistant.pinecone.dataset'))
                ->namespace($file->file_hash)
                ->query(
                    PineconeQueryRequest::build()
                        ->vector($embedding[0]->embedding)
                );

            return collect($vectorDatabaseResponse['matches'])
                ->map(fn (array $match) => sprintf('Page %d: \n %s', $match['metadata']['page'], $match['metadata']['text']))
                ->join("\n\n---\n\n");
        });

        $this->conversation->messages()->create([
            'content' => $prompt,
            'role' => RoleType::USER->value,
        ]);

        $response = $this->openAiClient->chat()->create([
            'model' => 'gpt-4',
            'messages' => array_merge(
                [
                    [
                        'role' => RoleType::SYSTEM->value,
                        'content' => sprintf('Here are relevant snippets from the file. Please base your answers on them: %s', $responses),
                    ],
                ],
                $this->conversation->messages->map(function (Message $message) {
                    return [
                        'role' => $message->role,
                        'content' => $message->content,
                    ];
                })->toArray(),
                [
                    [
                        'role' => RoleType::USER->value,
                        'content' => $prompt,
                    ],
                ]
            ),
        ]);

        $assistantResponse = $response->choices[0]?->message?->content ?? '';

        $this->conversation->messages()->create([
            'content' => $assistantResponse,
            'role' => RoleType::ASSISTANT->value,
        ]);

        return $assistantResponse;
    }
}
