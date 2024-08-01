<?php

namespace Mayank\Store\Tests;

use Illuminate\Support\Facades\Cache;

use Mayank\Store\Tests\Stores\Custom\CustomStoreFactory;

class CustomStoreTest extends \Orchestra\Testbench\TestCase
{
    public function test_get_returns_correct_data()
    {
        $store = CustomStoreFactory::make();

        $this->assertSame($store->data(), $store->get());
    }

    public function test_can_cache_data()
    {
        $store = CustomStoreFactory::make();
        $store->cache();

        $this->assertEquals($store->data(), $store->getCachedData());
        $this->assertEquals($store->data(), Cache::get($store->cacheKey()));
    }

    public function test_can_cache_data_while_overriding_cache_key()
    {
        $store = CustomStoreFactory::makeWithCacheKey();
        $store->cache();

        $this->assertEquals($store->data(), $store->getCachedData());
        $this->assertEquals($store->data(), Cache::get($store->cacheKey()));
    }

    public function test_can_cache_data_while_overriding_cache_duration()
    {
        $store = CustomStoreFactory::makeWithCacheDuration();
        $store->cache();

        $this->assertEquals($store->data(), $store->getCachedData());
        $this->assertEquals($store->data(), Cache::get($store->cacheKey()));
    }

    public function test_can_cache_data_while_overriding_cache_data()
    {
        $store = CustomStoreFactory::makeWithCacheData();
        $store->cache();

        $this->assertEquals($store->cacheData(), $store->getCachedData());
        $this->assertEquals($store->cacheData(), Cache::get($store->cacheKey()));
    }

    public function test_can_fetch_cached_data_without_manually_caching()
    {
        $store = CustomStoreFactory::make();

        $this->assertEquals($store->data(), $store->getCachedData());
        $this->assertEquals($store->data(), Cache::get($store->cacheKey()));
    }

    public function test_can_clear_cache()
    {
        $store = CustomStoreFactory::makeWithCacheData();
        $store->cache();

        $this->assertTrue(Cache::has($store->cacheKey()));

        $store->clearCache();

        $this->assertFalse(Cache::has($store->cacheKey()));
    }
}
