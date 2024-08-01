<?php

namespace Mayank\Store;

use Mayank\Store\Console\Commands\MakeStore;
use Mayank\Store\Console\Commands\StoreCache;
use Mayank\Store\Console\Commands\StoreClear;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->commands([
            MakeStore::class,
            StoreCache::class,
            StoreClear::class,
        ]);
    }
}
