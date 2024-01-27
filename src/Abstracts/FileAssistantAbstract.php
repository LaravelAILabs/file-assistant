<?php

namespace LaravelAILabs\FileAssistant\Abstracts;

use AdrianTanase\VectorStore\Facades\VectorStore;
use AdrianTanase\VectorStore\Providers\Pinecone\Requests\PineconeUpsertRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use LaravelAILabs\FileAssistant\Contracts\FileAssistantContract;
use LaravelAILabs\FileAssistant\FileWrapper;
use LaravelAILabs\FileAssistant\Models\Conversation;
use OpenAI;
use OpenAI\Client as OpenAIClient;

abstract class FileAssistantAbstract implements FileAssistantContract
{
    protected ?Model $userModel;

    protected ?Conversation $conversationModel;

    protected OpenAIClient $openAiClient;

    /**
     * @var FileWrapper[]
     */
    protected array $files;

    public function __construct()
    {
        $this->openAiClient = OpenAI::client(Config::get('file-assistant.openai.api_key'));
    }

    /**
     * Create embeddings from a file
     */
    protected function createEmbeddings(FileWrapper $fileWrapper): array
    {
        $content = Str::of($fileWrapper->getReader()->getText())
            ->split(pattern: "/\n\n/", limit: 8_000)
            ->toArray();

        return [
            $this->openAiClient->embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => $content,
            ])->embeddings,
            $content,
        ];
    }

    /**
     * Store the embeddings of a file in a namespace named after its file hash
     */
    protected function storeEmbeddings(FileWrapper $fileWrapper, array $embeddings, array $content): void
    {
        collect($embeddings)->chunk(20)->each(function (Collection $chunk, $chunkIndex) use ($content, $fileWrapper) {
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
            VectorStore::dataset(Config::get('file-assistant.pinecone.dataset'))
                ->namespace($fileWrapper->getHash())
                ->create($upsertRequests);
        });
    }
}
