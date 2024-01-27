<?php

namespace LaravelAILabs\FileAssistant\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static FileAssistant from(string $path)
 * @method static FileAssistant user(Illuminate\Database\Eloquent\Model $model)
 * @method static LaravelAILabs\FileAssistant\InterogateFile initialize()
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
