<?php

namespace Mayank\Store\Tests;

use Mockery\MockInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;

use Mayank\Store\Tests\Stores\Query\QueryStoreFactory;
use Mayank\Store\Tests\Stores\Query\LatestPosts;
use Mayank\Store\Tests\Stores\Query\LatestPostsWithCacheKey;
use Mayank\Store\Tests\Stores\Query\LatestPostsWithCacheDuration;

class QueryStoreTest extends \Orchestra\Testbench\TestCase
{
    public function fakePosts(): Collection
    {
        return new Collection(['post1', 'post2', 'post3']);
    }

    public function test_get_returns_correct_type_of_data()
    {
        $spy = $this->spy(LatestPosts::class);
        $latestPosts = QueryStoreFactory::make()->get();
        $spy->shouldHaveReceived('get');

        $this->assertInstanceOf(Collection::class, $latestPosts);
    }

    public function test_paginate_returns_correct_type_of_data()
    {
        $spy = $this->spy(LatestPosts::class);
        $latestPosts = QueryStoreFactory::make()->paginate();
        $spy->shouldHaveReceived('paginate');

        $this->assertInstanceOf(LengthAwarePaginator::class, $latestPosts);
    }

    public function test_simple_paginate_returns_correct_type_of_data()
    {
        $spy = $this->spy(LatestPosts::class);
        $latestPosts = QueryStoreFactory::make()->simplePaginate();
        $spy->shouldHaveReceived('simplePaginate');

        $this->assertInstanceOf(Paginator::class, $latestPosts);
    }

    public function test_can_cache_data()
    {
        $fakePosts = $this->fakePosts();

        $this->partialMock(LatestPosts::class, function (MockInterface $mock) use ($fakePosts) {
            $mock->shouldReceive('get')->andReturn($fakePosts);
        });

        $store = QueryStoreFactory::make();
        $store->cache();

        $this->assertEquals($fakePosts, $store->getCachedData());
        $this->assertEquals($fakePosts, Cache::get($store->cacheKey()));
    }

    public function test_can_cache_data_while_overriding_cache_key()
    {
        $fakePosts = $this->fakePosts();

        $this->partialMock(LatestPostsWithCacheKey::class, function (MockInterface $mock) use ($fakePosts) {
            $mock->shouldReceive('get')->andReturn($fakePosts);
        });

        $store = QueryStoreFactory::makeWithCacheKey();
        $store->cache();

        $this->assertEquals($fakePosts, $store->getCachedData());
        $this->assertEquals($fakePosts, Cache::get($store->cacheKey()));
    }

    public function test_can_cache_data_while_overriding_cache_duration()
    {
        $fakePosts = $this->fakePosts();

        $this->partialMock(LatestPostsWithCacheDuration::class, function (MockInterface $mock) use ($fakePosts) {
            $mock->shouldReceive('get')->andReturn($fakePosts);
        });

        $store = QueryStoreFactory::makeWithCacheDuration();
        $store->cache();

        $this->assertEquals($fakePosts, $store->getCachedData());
        $this->assertEquals($fakePosts, Cache::get($store->cacheKey()));
    }

    public function test_can_cache_data_while_overriding_cache_data()
    {
        $store = QueryStoreFactory::makeWithCacheData();
        $store->cache();

        $this->assertEquals($store->cacheData(), $store->getCachedData());
        $this->assertEquals($store->cacheData(), Cache::get($store->cacheKey()));
    }

    public function test_can_fetch_cached_data_without_manually_caching()
    {
        $store = QueryStoreFactory::makeWithCacheData();

        $this->assertEquals($store->cacheData(), $store->getCachedData());
        $this->assertEquals($store->cacheData(), Cache::get($store->cacheKey()));
    }

    public function test_can_clear_cache()
    {
        $store = QueryStoreFactory::makeWithCacheData();
        $store->cache();

        $this->assertTrue(Cache::has($store->cacheKey()));

        $store->clearCache();

        $this->assertFalse(Cache::has($store->cacheKey()));
    }
}
