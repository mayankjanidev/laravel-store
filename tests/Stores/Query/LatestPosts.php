<?php

namespace Mayank\Store\Tests\Stores\Query;

use Illuminate\Database\Eloquent\Builder;

use Mayank\Store\QueryStore;
use Mayank\Store\Tests\Models\Post;

class LatestPosts extends QueryStore
{
    public function query(): Builder
    {
        return Post::query();
    }
}
