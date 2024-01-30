<?php

namespace LaravelAILabs\FileAssistant\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \LaravelAILabs\FileAssistant\FileAssistant addFile(string $filePath)
 * @method static \LaravelAILabs\FileAssistant\FileAssistant setUser(Model $model)
 * @method static \LaravelAILabs\FileAssistant\FileAssistant setConversation(\LaravelAILabs\FileAssistant\Models\Conversation|int|null $conversation)
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
