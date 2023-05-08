<?php

namespace App\Services\Csv\Src\Contracts;

interface CsvServiceContract
{
    /**
     * @param  string  $filepath
     *
     * @return void
     */
    public function importClientsCsvToDB(string $filepath): void;

    /**
     * @return void
     */
    public function export(): void;
}
