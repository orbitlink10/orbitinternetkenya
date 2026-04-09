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
        $host = parse_url(config('app.url'), PHP_URL_HOST) ?: '';

        if ($request) {
            $host = $request->getHost();
            URL::forceRootUrl($request->getSchemeAndHttpHost());
            URL::forceScheme($request->getScheme());
        }

        if ($this->shouldForceIndexPhp($host)) {
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

    protected function shouldForceIndexPhp(string $host): bool
    {
        $configured = $this->normalizeBoolean(config('app.force_index_php'));

        if ($configured !== null) {
            return $configured;
        }

        return ! in_array($host, ['localhost', '127.0.0.1', '::1'], true)
            && ! str_ends_with($host, '.local')
            && ! str_ends_with($host, '.test');
    }

    protected function normalizeBoolean(mixed $value): ?bool
    {
        if ($value === null || is_bool($value)) {
            return $value;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
