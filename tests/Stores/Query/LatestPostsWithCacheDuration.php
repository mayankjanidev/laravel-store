<?php

namespace Mayank\Store\Tests\Stores\Query;

use DateTime;

use Illuminate\Database\Eloquent\Builder;

use Mayank\Store\QueryStore;
use Mayank\Store\Tests\Models\Post;

class LatestPostsWithCacheDuration extends QueryStore
{
    public function query(): Builder
    {
        return Post::query();
    }

    public function cacheDuration(): ?DateTime
    {
        return now()->addHours(2);
    }
}
