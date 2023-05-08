<?php

namespace App\Services\Csv\Src\Contracts;

interface ImporterContract
{
    /**
     * @param $dataChunkFromCsv
     *
     * @return void
     */
    public function import($dataChunkFromCsv): void;
}
