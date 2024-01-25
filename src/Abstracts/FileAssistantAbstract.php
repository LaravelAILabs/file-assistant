<?php

namespace LaravelAILabs\FileAssistant\Abstracts;

use AdrianTanase\VectorStore\Facades\VectorStore;
use AdrianTanase\VectorStore\Providers\Pinecone\Requests\PineconeUpsertRequest;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use LaravelAILabs\FileAssistant\Contracts\FileAssistantContract;
use OpenAI\Laravel\Facades\OpenAI;

abstract class FileAssistantAbstract implements FileAssistantContract
{
    protected Filesystem $filesystem;

    protected FileReaderAbstract $reader;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    private function createEmbeddings(): array
    {
        return OpenAI::embeddings()->create([
            'model' => 'text-embedding-ada-002',
            'input' => $this->reader->getText(),
        ])->embeddings;
    }

    private function storeEmbeddings(array $embeddings): void
    {
        $content = Str::of($this->reader->getText())
            ->split("/\f/")
            ->toArray();

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

            VectorStore::dataset('vector-store')
                ->namespace('general')
                ->create($upsertRequests);
        });
    }

    protected function process(): void
    {
        $this->storeEmbeddings($this->createEmbeddings());
    }
}
