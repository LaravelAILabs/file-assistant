<?php

namespace LaravelAILabs\FileAssistant;

use AdrianTanase\VectorStore\Facades\VectorStore;
use AdrianTanase\VectorStore\Providers\Pinecone\Requests\PineconeQueryRequest;
use Illuminate\Support\Facades\Config;
use LaravelAILabs\FileAssistant\Abstracts\InterrogateFileAbstract;
use LaravelAILabs\FileAssistant\Models\File;

class InterrogateFile extends InterrogateFileAbstract
{
    public function ask(string $prompt): string
    {
        $embedding = $this->embedPrompt($prompt);

        // query the vector database for the embedding results
        $responses = $this->conversation->files->map(function (File $file) use ($embedding) {
            $vectorDatabaseResponse = VectorStore::dataset(Config::get('file-assistant.pinecone.dataset'))
                ->namespace($file->file_hash)
                ->query(
                    PineconeQueryRequest::build()
                        ->vector($embedding)
                );

            return collect($vectorDatabaseResponse['matches'])
                ->map(fn (array $match) => sprintf('Page %d: \n %s', $match['metadata']['page'], $match['metadata']['text']))
                ->join("\n\n---\n\n");
        });

        $response = $this->openAiClient->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => sprintf('Here are relevant snippets from the file. Please base your answers on them: %s', $responses),
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
        ]);

        return $response->choices[0]?->message?->content ?? '';
    }
}
