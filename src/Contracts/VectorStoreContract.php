<?php

namespace LaravelAILabs\FileAssistant\Contracts;

interface VectorStoreContract
{
    public function storeData(): self;

    public function queryData(): self;
}
