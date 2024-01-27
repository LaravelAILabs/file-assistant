<?php

namespace LaravelAILabs\FileAssistant\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use LaravelAILabs\FileAssistant\InterrogateFile;

/**
 * @method static FileAssistant from(string $path)
 * @method static FileAssistant user(Model $model)
 * @method static InterrogateFile initialize()
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
