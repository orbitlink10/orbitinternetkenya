<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Keep generated URLs (url(), asset(), route()) on the current host/scheme
        // to avoid cross-domain redirects between starlinkkenyainstallers.co.ke
        // and spacelinkkenya.co.ke.
        if (! $this->app->runningInConsole()) {
            $request = $this->app['request'];
            if ($request) {
                URL::forceRootUrl($request->getSchemeAndHttpHost());
                URL::forceScheme($request->getScheme());
            }
        }
    }
}
