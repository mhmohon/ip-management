<?php
namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

trait ApiResponser
{
    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30/60, function () use ($data) {
            return $data;
        });
    }
}
