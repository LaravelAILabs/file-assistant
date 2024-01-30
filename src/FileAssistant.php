<?php

namespace LaravelAILabs\FileAssistant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use LaravelAILabs\FileAssistant\Abstracts\FileAssistantAbstract;
use LaravelAILabs\FileAssistant\Models\Conversation;

/**
 * @class FileAssistant
 *
 * This class represents a file assistant that helps with file operations and conversations.
 */
class FileAssistant extends FileAssistantAbstract
{
    /**
     * (Optional) Add a file
     */
    public function addFile(string $filePath): self
    {
        $this->files[] = new FileWrapper($filePath);

        return $this;
    }

    /**
     * (Optional) Sets the user model.
     *
     * @param  Model  $model  The user model to be set.
     */
    public function setUser(Model $model): self
    {
        $this->userModel = $model;

        return $this;
    }

    /**
     * (Optional) Resume a conversion
     *
     * @return $this
     */
    public function setConversation(Conversation|int|null $conversation): self
    {
        $this->conversationModel = is_numeric($conversation) ? Conversation::find($conversation) : $conversation;

        return $this;
    }

    /**
     * Initializes the file interrogation process.
     *
     * This method creates a new conversation, generates a file hash, associates the file with the conversation,
     * creates embeddings for the file's content, and stores the embeddings in a vector database. Finally, it returns
     * an instance of the `InterrogateFile` class.
     *
     * @return InterrogateFile The initialized InterrogateFile instance.
     */
    public function initialize(): InterrogateFile
    {
        // create the conversation
        $conversation = $this->conversationModel ??
                        Conversation::create([
                            'user_id' => $this->userModel?->id ?? Auth::user()?->getAuthIdentifier() ?? null,
                        ]);

        // create the file hash
        foreach ($this->files as $file) {
            $model = $file->getModel();

            // associate the file with the conversation
            $conversation->files()->attach($model);

            // embed the file's content
            if ($model->wasRecentlyCreated) {
                [$embeddings, $content] = $this->createEmbeddings($file);

                // store the embeddings in a vector database
                $this->storeEmbeddings($file, $embeddings, $content);
            }
        }

        return new InterrogateFile($conversation, $this->openAiClient);
    }
}
