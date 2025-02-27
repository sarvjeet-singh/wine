<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;
use App\Models\ConfigurationSetting;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Queue;
use App\Services\ErrorLoggerService;

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

        Queue::failing(function (JobFailed $event) {
            ErrorLoggerService::log(
                'error',
                'Queue Job Failed: ' . $event->exception->getMessage(),
                ['job' => $event->job->resolveName()],
                $event->exception->getFile(),
                $event->exception->getLine()
            );
        });
    }
}
