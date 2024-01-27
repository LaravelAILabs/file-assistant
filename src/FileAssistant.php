<?php

namespace LaravelAILabs\FileAssistant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use LaravelAILabs\FileAssistant\Abstracts\FileAssistantAbstract;
use LaravelAILabs\FileAssistant\Exceptions\UndefinedReaderException;
use LaravelAILabs\FileAssistant\Models\Conversation;
use LaravelAILabs\FileAssistant\Models\File;
use LaravelAILabs\FileAssistant\Readers\PdfReader;
use LaravelAILabs\FileAssistant\Readers\TextReader;
use LaravelAILabs\FileAssistant\Readers\WordReader;

/**
 * @class FileAssistant
 *
 * This class represents a file assistant that helps with file operations and conversations.
 */
class FileAssistant extends FileAssistantAbstract
{
    private ?Model $userModel;

    private ?Conversation $conversationModel;

    public function from(string $filePath): self
    {
        // instantiate the reader
        $this->reader = match ($this->filesystem->mimeType($filePath)) {
            'application/pdf' => new PdfReader($filePath),
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword' => new WordReader($filePath),
            'text/plain' => new TextReader($filePath),
            default => throw new UndefinedReaderException,
        };

        return $this;
    }

    /**
     * Sets the user model.
     *
     * @param  Model  $model  The user model to be set.
     */
    public function user(Model $model): self
    {
        $this->userModel = $model;

        return $this;
    }

    /**
     * @return $this
     */
    public function conversation(Conversation $conversation): self
    {
        $this->conversationModel = $conversation;

        return $this;
    }

    /**
     * Initializes the file interrogation process.
     *
     * This method creates a new conversation, generates a file hash, associates the file with the conversation,
     * creates embeddings for the file's content, and stores the embeddings in a vector database. Finally, it returns
     * an instance of the `InterogateFile` class.
     *
     * @return InterrogateFile The initialized InterogateFile instance.
     */
    public function initialize(): InterrogateFile
    {
        // create the conversation
        $conversation = $this->conversationModel ??
                        Conversation::create([
                            'user_id' => $this->userModel?->id ?? Auth::user()?->getAuthIdentifier() ?? null,
                        ]);

        // create the file hash
        $file = File::firstOrCreate([
            'file_hash' => $this->reader->hash(),
        ]);

        // associate the file with the conversation
        $conversation->files()->associate($file);

        // embed the file's content
        if ($file->wasRecentlyCreated) {
            [$embeddings, $content] = $this->createEmbeddings();

            // store the embeddings in a vector database
            $this->storeEmbeddings($embeddings, $content);
        }

        return new InterrogateFile($conversation, $this->openAiClient);
    }
}
