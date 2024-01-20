<?php

namespace LaravelAILabs\FileAssistant\Contracts;

interface FileReaderContract
{
	function limit(int $limit): self;
	function getText(): string;
}
