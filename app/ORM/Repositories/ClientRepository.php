<?php

namespace App\ORM\Repositories;

use App\Models\Client;
use App\ORM\Repositories\Contracts\ClientRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientRepository implements ClientRepositoryContract
{
    /**
     * @param  Builder|null  $query
     * @param  int|null  $perPage
     * @param  int|null  $page
     *
     * @return LengthAwarePaginator
     */
    public function getList(Builder $query = null, int $perPage = null, int $page = null): LengthAwarePaginator
    {
        if (is_null($query)) {
            $query = Client::query();
        }

        return $query->orderBy('birth_date')->paginate(perPage: $perPage, page: $page);
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return Client::query()->count('id');
    }
}
