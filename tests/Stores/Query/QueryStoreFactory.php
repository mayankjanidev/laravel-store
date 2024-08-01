<?php

namespace Mayank\Store\Tests\Stores\Query;

use Illuminate\Support\Facades\App;

class QueryStoreFactory
{
    public static function make(): LatestPosts
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
