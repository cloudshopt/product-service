<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Prometheus\CollectorRegistry;

class PrometheusMetrics
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);

        $response = $next($request);

        $duration = microtime(true) - $start;

        $route = $request->route();
        $routeLabel = $route?->getName()
            ?? $route?->uri()
            ?? 'unknown';

        $method = $request->method();
        $status = (string) $response->getStatusCode();
        $service = config('app.name', 'service');

        $registry = app(CollectorRegistry::class);

        // Counter: request count
        $counter = $registry->getOrRegisterCounter(
            'cloudshopt',
            'http_requests_total',
            'Total HTTP requests',
            ['service', 'method', 'route', 'status']
        );
        $counter->inc([$service, $method, $routeLabel, $status]);

        // Histogram: request latency
        $hist = $registry->getOrRegisterHistogram(
            'cloudshopt',
            'http_request_duration_seconds',
            'HTTP request duration in seconds',
            ['service', 'method', 'route', 'status'],
            // buckets (sekunde)
            [0.01, 0.025, 0.05, 0.1, 0.25, 0.5, 1, 2.5, 5]
        );
        $hist->observe($duration, [$service, $method, $routeLabel, $status]);

        return $response;
    }
}
