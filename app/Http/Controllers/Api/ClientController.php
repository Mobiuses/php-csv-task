<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\ClientFilter;
use App\Http\Requests\ClientsRequest;
use App\Http\Resources\ClientResource;
use App\ORM\Repositories\Contracts\ClientRepositoryContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientController extends Controller
{
    public const PER_PAGE_DEFAULT = 25;

    /**
     * Display a listing of the resource.
     *
     * @param  ClientsRequest  $request
     * @param  ClientFilter  $filter
     * @param  ClientRepositoryContract  $clientRepository
     *
     * @return AnonymousResourceCollection
     */
    public function list(
        ClientsRequest $request,
        ClientFilter $filter,
        ClientRepositoryContract $clientRepository
    ): AnonymousResourceCollection {
        $clients = $clientRepository->getList($filter->getQueryFromData(),
            $request->get('per_page') ?: self::PER_PAGE_DEFAULT);

        return ClientResource::collection($clients);
    }
}
