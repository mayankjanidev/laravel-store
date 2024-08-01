<?php

namespace Mayank\Store\Tests\Stores\Custom;

use DateTime;

use Mayank\Store\CustomStore;

class LatestPostsWithCacheDuration extends CustomStore
{
    public function data(): array
    {
        return ['original_post1', 'original_post2', 'original_post3'];
    }

    public function cacheDuration(): ?DateTime
    {
        return now()->addHours(2);
    }
}
