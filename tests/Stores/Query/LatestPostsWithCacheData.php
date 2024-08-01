<?php

namespace Mayank\Store\Tests\Stores\Query;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

use Mayank\Store\QueryStore;
use Mayank\Store\Tests\Models\Post;

class LatestPostsWithCacheData extends QueryStore
{
    public function query(): Builder
    {
        return Post::query();
    }

    public function cacheData(): Collection
    {
        return new Collection(['overriden_post_1', 'overriden_post_2', 'overriden_post_3']);
    }
}
