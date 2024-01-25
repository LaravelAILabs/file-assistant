<?php

// config for LaravelAILabs/FileAssistant
return [
    'tables' => [
        'conversations' => env('FILE_ASSISTANT_CONVERSATIONS_TABLE', 'conversations'),
        'messages' => env('FILE_ASSISTANT_MESSAGES_TABLE', 'messages'),
    ],
];
