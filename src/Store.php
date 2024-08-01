<?php

namespace Mayank\Store;

use DateTime;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Store
{
    public function cacheKey(): string
    {
        return strtolower(Str::kebab(get_class($this)));
    }

    public function cacheDuration(): ?DateTime
    {
        return null;
    }

    public function cacheData()
    {
        return null;
    }

    public function getCachedData()
    {
        if ($this->cacheDuration() != null) {
            return Cache::remember($this->cacheKey(), $this->cacheDuration(), function () {
                return $this->cacheData();
            });
        } else {
            return Cache::rememberForever($this->cacheKey(), function () {
                return $this->cacheData();
            });
        }
    }

    public function cache(): void
    {
        if ($this->cacheDuration() != null)
            Cache::set($this->cacheKey(), $this->cacheData(), $this->cacheDuration());

        else
            Cache::forever($this->cacheKey(), $this->cacheData());
    }

    public function clearCache(): void
    {
        Cache::forget($this->cacheKey());
    }
}
