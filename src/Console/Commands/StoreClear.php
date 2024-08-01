<?php

namespace Mayank\Store\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class StoreClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:clear {name} {--absolute}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cache for a data store.';

    protected function getStoreClass(string $name): string
    {
        if ($this->option('absolute')) {
            return $name;
        }

        $storeInDefaultLocation = $this->laravel->getNamespace() . 'Stores' . '\\' . $name;
        $storeInUserDefinedLocation = $this->laravel->getNamespace() . $name;

        if (class_exists($storeInDefaultLocation)) {
            return $storeInDefaultLocation;
        }

        return $storeInUserDefinedLocation;
    }

    public function handle()
    {
        $store = App::make($this->getStoreClass($this->argument('name')));
        $store->clearCache();
    }
}
