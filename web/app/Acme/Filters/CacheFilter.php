<?php
namespace Acme\Filters;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class CacheFilter
{
    public function fetch(Route $route, Request $request)
    {
        $key = $this->makeCacheKey($request->url());
        if (Cache::has($key)) return Cache::get($key);
    }

    public function put(Route $route, Request $request, Response $response)
    {
        $key = $this->makeCacheKey($request->url());
        if (!Cache::has($key)) Cache::put($key, $response->getContent(), 60);
    }

    private function makeCacheKey($url)
    {
        return 'route_' . Str::slug($url);
    }
}