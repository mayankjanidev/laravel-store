<?php

namespace Mayank\Store\Tests\Stores\Custom;

use Mayank\Store\CustomStore;

class LatestPostsWithCacheKey extends CustomStore
{
    public function data(): array
    {
        return ['original_post1', 'original_post2', 'original_post3'];
    }

    public function cacheKey(): string
    {
        return 'latest-posts';
    }
}
