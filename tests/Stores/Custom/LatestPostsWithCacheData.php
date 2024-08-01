<?php

namespace Mayank\Store\Tests\Stores\Custom;

use Mayank\Store\CustomStore;

class LatestPostsWithCacheData extends CustomStore
{
    public function data(): array
    {
        return ['original_post1', 'original_post2', 'original_post3'];
    }

    public function cacheData(): array
    {
        return ['overriden_post_1', 'overriden_post_2', 'overriden_post_3'];
    }
}
