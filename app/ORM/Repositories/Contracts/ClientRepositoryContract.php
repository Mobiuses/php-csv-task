<?php

namespace App\ORM\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClientRepositoryContract
{
    /**
     * @param  Builder|null  $query
     * @param  int|null  $perPage
     * @param  int|null  $page
     *
     * @return LengthAwarePaginator
     */
    public function getList(Builder $query = null, int $perPage = null, int $page = null): LengthAwarePaginator;

    /**
     * @return int
     */
    public function getTotalCount(): int;
}
