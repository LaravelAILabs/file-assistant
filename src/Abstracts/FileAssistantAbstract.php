<?php

namespace LaravelAILabs\FileAssistant\Abstracts;

use AdrianTanase\VectorStore\Facades\VectorStore;
use AdrianTanase\VectorStore\Providers\Pinecone\Requests\PineconeUpsertRequest;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use LaravelAILabs\FileAssistant\Contracts\FileAssistantContract;
use OpenAI;
use OpenAI\Client as OpenAIClient;

abstract class FileAssistantAbstract implements FileAssistantContract
{
    protected Filesystem $filesystem;

    protected FileReaderAbstract $reader;

    protected OpenAIClient $openAiClient;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->openAiClient = OpenAI::client(Config::get('file-assistant.openai.api_key'));
    }

    protected function createEmbeddings(): array
    {
        $content = Str::of($this->reader->getText())
            ->split("/\f/")
            ->toArray();

        return [
            $this->openAiClient->embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => $content,
            ])->embeddings,
            $content,
        ];
    }

    protected function storeEmbeddings(array $embeddings, array $content): void
    {
        collect($embeddings)->chunk(20)->each(function (Collection $chunk, $chunkIndex) use ($content) {
            $upsertRequests = $chunk->pluck('embedding')->map(function ($embedding, $index) use ($chunkIndex, $content) {
                return PineconeUpsertRequest::build()
                    ->id((string) ($chunkIndex * 20 + $index))
                    ->values($embedding)
                    ->metadata([
                        'text' => $content[$chunkIndex * 20 + $index],
                        'page' => $chunkIndex * 20 + $index + 1,
                    ]);
            })->toArray();

            // store inside a vector store
            VectorStore::dataset('vector-store')
                ->namespace($this->reader->hash())
                ->create($upsertRequests);
        });
    }
}
