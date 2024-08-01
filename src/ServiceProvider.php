<?php

namespace Mayank\Store;

use Mayank\Store\Console\Commands\MakeStore;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeStore::class,
            ]);
        }
    }
}
