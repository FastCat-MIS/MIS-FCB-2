<?php

namespace App\Providers;

use App\Models\Operations\Port;
use App\Observers\PortObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Port::observe(PortObserver::class);
    }
}