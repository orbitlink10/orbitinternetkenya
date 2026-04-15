<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // Keep generated URLs on the current host/scheme to avoid cross-domain
        // redirects between legacy domains and the active hostname.
        $request = $this->app->bound('request') ? $this->app['request'] : null;

        if ($request) {
            URL::forceRootUrl($request->getSchemeAndHttpHost());
            URL::forceScheme($request->getScheme());
        }

        if ($this->shouldForceIndexPhp()) {
            URL::formatPathUsing(static function (string $path) {
                if ($path === '' || $path === '/') {
                    return '/index.php';
                }

                if (str_starts_with($path, '/index.php')) {
                    return $path;
                }

                return '/index.php' . (str_starts_with($path, '/') ? $path : '/' . $path);
            });
        }
    }

    protected function shouldForceIndexPhp(): bool
    {
        return $this->normalizeBoolean(config('app.force_index_php')) === true;
    }

    protected function normalizeBoolean(mixed $value): ?bool
    {
        if ($value === null || is_bool($value)) {
            return $value;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
