<?php

namespace LaravelAILabs\FileAssistant\Exceptions;

use RuntimeException;

class UndefinedReaderException extends RuntimeException
{
    protected $message = 'Undefined reader';
}
