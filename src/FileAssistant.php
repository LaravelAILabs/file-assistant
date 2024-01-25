<?php

namespace LaravelAILabs\FileAssistant;

use LaravelAILabs\FileAssistant\Abstracts\FileAssistantAbstract;
use LaravelAILabs\FileAssistant\Exceptions\UndefinedReaderException;
use LaravelAILabs\FileAssistant\Readers\PdfReader;
use LaravelAILabs\FileAssistant\Readers\TextReader;
use LaravelAILabs\FileAssistant\Readers\WordReader;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Chat\CreateResponse;

class FileAssistant extends FileAssistantAbstract
{
    public function from(string $path): self
    {
        // instantiate the reader
        $this->reader = match ($this->filesystem->mimeType($path)) {
            'application/pdf' => new PdfReader($path),
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword' => new WordReader($path),
            'text/plain' => new TextReader($path),
            default => throw new UndefinedReaderException,
        };

        return $this;
    }

    public function query(string $query): string
    {
        $this->process();

        /**
         * @var CreateResponse $response
         */
        $response = OpenAi::chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                'role' => 'user',
                'content' => $query,
            ],
        ]);

        return $response->choices[0]->message->content ?? '';
    }
}
