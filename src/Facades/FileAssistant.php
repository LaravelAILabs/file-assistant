<?php

namespace LaravelAILabs\FileAssistant\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static FileAssistant addFile(string $filePath)
 * @method static FileAssistant setUser(Model $model)
 * @method static FileAssistant setConversation(\LaravelAILabs\FileAssistant\Models\Conversation $conversation)
 * @method static \LaravelAILabs\FileAssistant\InterrogateFile initialize()
 *
 * @see \LaravelAILabs\FileAssistant\FileAssistant
 */
class FileAssistant extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LaravelAILabs\FileAssistant\FileAssistant::class;
    }
}
