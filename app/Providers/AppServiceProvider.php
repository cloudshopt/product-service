<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Redis::setDefaultOptions([
            'host' => env('REDIS_HOST'),
            'port' => (int) env('REDIS_PORT', 6379),
            'password' => env('REDIS_PASSWORD') ?: null,
            'timeout' => 0.1,
            'read_timeout' => 10,
            'persistent_connections' => true,
            'prefix' => config('app.name', 'service') . '_' . gethostname(),
        ]);


        $this->app->singleton(CollectorRegistry::class, function () {
            return new CollectorRegistry(new Redis());
        });
    }

    public function boot(): void
    {
        //
    }
}
