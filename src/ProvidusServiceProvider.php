<?php

namespace Providus\Providus;

use Illuminate\Http\Request;
use Providus\Providus\SignatureValidator\DefaultSignatureValidator;
use Providus\Providus\SignatureValidator\SignatureValidator;
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
            ->hasConfigFile()
            ->hasRoute('web');
    }

    public function packageRegistered()
    {
        $this->app->singleton(
            abstract: SignatureValidator::class,
            concrete: fn($app) => $app->make(config('providus-sdk.webhook.signature_validator'))
        );
    }


}
