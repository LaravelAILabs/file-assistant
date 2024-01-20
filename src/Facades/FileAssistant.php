<?php

namespace LaravelAILabs\FileAssistant\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LaravelAILabs\FileAssistant\FileAssistant
 */
class FileAssistant extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LaravelAILabs\FileAssistant\FileAssistant::class;
    }
}
