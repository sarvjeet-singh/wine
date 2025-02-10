<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;
use App\Models\ConfigurationSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        // Load the configuration settings
        $configSettings = ConfigurationSetting::where('status', 1)->pluck('value', 'key')->toArray();
        config()->set('site', $configSettings);  // Custom key for your site config
    }
}
