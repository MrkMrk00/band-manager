<?php

namespace BandManager\App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        require_once base_path('app-lib/blade_ext.php');
    }

    public function register(): void
    {
    }
}
