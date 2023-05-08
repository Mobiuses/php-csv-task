<?php

namespace App\Services\Csv\Src\Contracts;

interface ExporterContract
{
    /**
     * @return void
     */
    public function exportToCsv(): void;
}
