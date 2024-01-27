<?php

// config for LaravelAILabs/FileAssistant
return [
    'tables' => [
        'conversations' => env('FILE_ASSISTANT_CONVERSATIONS_TABLE', 'fa_conversations'),
        'messages' => env('FILE_ASSISTANT_MESSAGES_TABLE', 'fa_messages'),
        'files' => env('FILE_ASSISTANT_FILES_TABLE', 'fa_files'),
    ],
    'openai' => [
        'api_key' => env('OPENAI_API_KEY', ''),
    ],
    'pinecone' => [
        'dataset' => env('FILE_ASSISTANT_PINECONE_DATASET', ''),
    ],
];
