<?php

namespace Mayank\Store\Tests\Stores\Custom;

use Illuminate\Support\Facades\App;

class CustomStoreFactory
{
    public static function make()
    {
        return App::make(LatestPosts::class);
    }

    public static function makeWithCacheKey(): LatestPostsWithCacheKey
    {
        return App::make(LatestPostsWithCacheKey::class);
    }

    public static function makeWithCacheData(): LatestPostsWithCacheData
    {
        return App::make(LatestPostsWithCacheData::class);
    }

    public static function makeWithCacheDuration(): LatestPostsWithCacheDuration
    {
        return App::make(LatestPostsWithCacheDuration::class);
    }
}
