<?php

namespace Winipayer\Winipayer;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Winipayer\Winipayer\Commands\WinipayerCommand;

class WinipayerServiceProvider extends PackageServiceProvider
{

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('package-winipayer-test')
            ->hasConfigFile('laravel-winipayer')
            ->hasCommand(WinipayerCommand::class);
    }
}