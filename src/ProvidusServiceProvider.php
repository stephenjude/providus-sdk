<?php

namespace Providus\Providus;

use Providus\Providus\SignatureValidator\SignatureValidator;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ProvidusServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('providus-sdk')
            ->hasConfigFile()
            ->hasRoute('web');
    }

    public function packageRegistered()
    {
        $this->app->singleton(
            abstract: SignatureValidator::class,
            concrete: fn ($app) => $app->make(config('providus-sdk.webhook.signature_validator'))
        );
    }
}
