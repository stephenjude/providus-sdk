<?php

namespace Providus\Providus;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Providus\Providus\Commands\ProvidusCommand;

class ProvidusServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('providus-sdk')
            ->hasConfigFile();
    }
}
