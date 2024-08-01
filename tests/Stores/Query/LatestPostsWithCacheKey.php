<?php

namespace Mayank\Store\Tests\Stores\Query;

use Illuminate\Database\Eloquent\Builder;

use Mayank\Store\QueryStore;
use Mayank\Store\Tests\Models\Post;

class LatestPostsWithCacheKey extends QueryStore
{
    public function query(): Builder
    {
        return Post::query();
    }

    public function cacheKey(): string
    {
        return 'latest-posts';
    }
}
