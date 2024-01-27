<?php

namespace LaravelAILabs\FileAssistant\Test;

use AdrianTanase\VectorStore\Enums\VectorStoreProviderType;
use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    protected function getEnvironmentSetUp($app)
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../', '.env.testing');
        $dotenv->load();

        // set pinecone api keys
        $app['config']->set('vector-store.default', VectorStoreProviderType::PINECONE->value);
        $app['config']->set('vector-store.pinecone_api_key', env('VECTOR_STORE_PINECONE_API_KEY', ''));
        $app['config']->set('vector-store.pinecone_environment', env('VECTOR_STORE_PINECONE_ENVIRONMENT', ''));

        // set open api key and pinecone dataset
        $app['config']->set('file-assistant.openai.api_key', env('OPENAI_API_KEY', ''));
        $app['config']->set('file-assistant.pinecone.dataset', env('FILE_ASSISTANT_PINECONE_DATASET', ''));

        // set tables
        $app['config']->set('file-assistant.tables.conversations', 'fa_conversations');
        $app['config']->set('file-assistant.tables.messages', 'fa_messages');
        $app['config']->set('file-assistant.tables.files', 'fa_files');
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
