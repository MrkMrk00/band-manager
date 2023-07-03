<?php

namespace BandManager\App\Providers;

use BandManager\UglifyJS;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot(): void
    {
    }

    public function register(): void
    {
        $this->app->singleton(UglifyJS::class);
    }

    public function provides(): array
    {
        return [UglifyJS::class];
    }
}
