<?php

namespace App\Http\Controllers;

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

class MetricsController extends Controller
{
    public function __invoke()
    {
//        $token = env('METRICS_BEARER_TOKEN');
//        if ($token) {
//            $auth = request()->header('Authorization', '');
//            if (!preg_match('/^Bearer\s+(.+)$/i', $auth, $m) || $m[1] !== $token) {
//                return response()->json(['message' => 'Unauthorized'], 401);
//            }
//        }

        $registry = app(CollectorRegistry::class);

        $renderer = new RenderTextFormat();
        $result = $renderer->render($registry->getMetricFamilySamples());

        return response($result, 200, [
            'Content-Type' => RenderTextFormat::MIME_TYPE,
            'Cache-Control' => 'no-store',
        ]);
    }
}
