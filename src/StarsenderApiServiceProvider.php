<?php

namespace Rupadana\StarsenderApi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Rupadana\StarsenderApi\Commands\StarsenderApiCommand;

class StarsenderApiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('starsender-api')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_starsender-api_table')
            ->hasCommand(StarsenderApiCommand::class);
    }
}
