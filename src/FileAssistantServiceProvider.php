<?php

namespace LaravelAILabs\FileAssistant;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FileAssistantServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('file-assistant')
            ->hasConfigFile('file-assistant')
            ->hasMigrations([
                '0000_00_00_000000_create_conversations_table',
                '0000_00_00_000001_create_messages_table',
            ]);
    }
}
