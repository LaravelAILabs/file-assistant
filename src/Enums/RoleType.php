<?php

namespace LaravelAILabs\FileAssistant\Enums;

enum RoleType: string
{
    case USER = 'user';
    case ASSISTANT = 'assistant';
    case SYSTEM = 'system';
}
