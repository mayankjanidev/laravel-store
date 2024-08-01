<?php

namespace Mayank\Store\Tests\Stores\Custom;

class CustomStoreFactory
{
    public static function make(): LatestPosts
    {
        return new LatestPosts;
    }

    public static function makeWithCacheKey(): LatestPostsWithCacheKey
    {
        return new LatestPostsWithCacheKey;
    }

    public static function makeWithCacheData(): LatestPostsWithCacheData
    {
        return new LatestPostsWithCacheData;
    }

    public static function makeWithCacheDuration(): LatestPostsWithCacheDuration
    {
        return new LatestPostsWithCacheDuration;
    }
}
