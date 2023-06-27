<?php

namespace BandManager\App\Providers;

use BandManager\App\Api\Facebook;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ForeignApisServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(Facebook::class, Facebook::class);
    }

    public function provides(): array
    {
        return [Facebook::class];
    }
}
