<?php

namespace Mayank\Store\Tests;

use Illuminate\Support\Facades\Cache;

use Mayank\Store\ServiceProvider;
use Mayank\Store\Console\Commands\StoreCache;
use Mayank\Store\Console\Commands\StoreClear;

use Mayank\Store\Tests\Stores\Custom\CustomStoreFactory;

class CommandTest extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    public function test_store_cache_command_works()
    {
        $store = CustomStoreFactory::make();

        $this->assertFalse(Cache::has($store->cacheKey()));

        $this->artisan(StoreCache::class, [
            'name' => $store::class,
            '--absolute' => true
        ]);

        $this->assertTrue(Cache::has($store->cacheKey()));
    }

    public function test_store_clear_command_works()
    {
        $store = CustomStoreFactory::make();
        $store->cache();

        $this->assertTrue(Cache::has($store->cacheKey()));

        $this->artisan(StoreClear::class, [
            'name' => $store::class,
            '--absolute' => true
        ]);

        $this->assertFalse(Cache::has($store->cacheKey()));
    }
}
