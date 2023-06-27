<?php

namespace BandManager;

use Illuminate\Support\ServiceProvider;

class LibServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        require_once base_path('app-lib/blade_ext.php');
    }
}
