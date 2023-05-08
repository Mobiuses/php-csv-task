<?php

namespace Database\Seeders;

use App\Services\Csv\Src\Contracts\CsvServiceContract;
use Illuminate\Database\Seeder;

class ClientFromCsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = app(CsvServiceContract::class);

        $service->importClientsCsvToDB(storage_path('datasets/dataset.txt'));
    }
}
