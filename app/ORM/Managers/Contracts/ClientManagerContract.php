<?php

namespace App\ORM\Managers\Contracts;

interface ClientManagerContract
{
    /**
     * @param  array  $values
     *
     * @return void
     */
    public function bulkInsert(array $values): void;
}
