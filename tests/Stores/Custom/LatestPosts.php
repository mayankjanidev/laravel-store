<?php

namespace Mayank\Store\Tests\Stores\Custom;

use Mayank\Store\CustomStore;

class LatestPosts extends CustomStore
{
    public function data(): array
    {
        return ['original_post1', 'original_post2', 'original_post3'];
    }
}
