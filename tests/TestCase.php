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

        $app['config']->set('vector-store.default', VectorStoreProviderType::PINECONE->value);
        $app['config']->set('vector-store.pinecone_api_key', env('VECTOR_STORE_PINECONE_API_KEY', ''));
        $app['config']->set('vector-store.pinecone_environment', env('VECTOR_STORE_PINECONE_ENVIRONMENT', ''));
        $app['config']->set('file-assistant.openai.api_key', env('OPENAI_API_KEY', ''));
    }

    protected function defineDatabaseMigrations()
    {
        $migration = include_once __DIR__.'/../database/migrations/0000_00_00_000000_create_conversations_table.php';
        (new $migration)->up();

        $migration = include_once __DIR__.'/../database/migrations/0000_00_00_000001_create_messages_table.php';
        (new $migration)->up();

        $migration = include_once __DIR__.'/../database/migrations/0000_00_00_000002_create_files_table.php';
        (new $migration)->up();
    }
}
