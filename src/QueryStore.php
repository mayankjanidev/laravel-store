<?php

namespace Mayank\Store;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;

abstract class QueryStore extends Store
{
    abstract public function query(): QueryBuilder | EloquentBuilder | Relation;

    public function get(...$arguments): Collection
    {
        return $this->query()->get(...$arguments);
    }

    public function paginate(...$arguments): LengthAwarePaginator
    {
        return $this->query()->paginate(...$arguments);
    }

    public function simplePaginate(...$arguments): Paginator
    {
        return $this->query()->simplePaginate(...$arguments);
    }

    public function cacheData(): Collection|LengthAwarePaginator|Paginator
    {
        return $this->get();
    }
}
