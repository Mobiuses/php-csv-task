<?php

namespace App\ORM\Managers;

use App\Models\Client;
use App\ORM\Managers\Contracts\ClientManagerContract;

class ClientManager implements ClientManagerContract
{
    /**
     * @param  array  $values
     *
     * @return void
     */
    public function bulkInsert(array $values): void
    {
        Client::insert($values);
    }
}
