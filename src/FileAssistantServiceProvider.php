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
            ->hasConfigFile('file-assistant');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
