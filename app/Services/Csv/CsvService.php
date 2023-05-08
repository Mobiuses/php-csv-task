<?php

namespace App\Services\Csv;

use App\Models\Client;
use App\Services\Csv\Src\Contracts\CsvServiceContract;
use App\Services\Csv\Src\Contracts\ExporterContract;
use App\Services\Csv\Src\Contracts\ImporterContract;
use App\Services\Csv\Src\Contracts\ReaderContract;

class CsvService implements CsvServiceContract
{
    /**
     * @param  ImporterContract  $importer
     * @param  ExporterContract  $exporter
     * @param  ReaderContract  $reader
     */
    public function __construct(
        private ImporterContract $importer,
        private ExporterContract $exporter,
        private ReaderContract $reader,
    ) {
    }

    /**
     * @param  string  $filepath
     *
     * @return void
     */
    public function importClientsCsvToDB(string $filepath): void
    {
        $reader = $this->reader->readFromFile($filepath);
        $this->importer->setMapping(Client::getBaseFields());

        while ( ! empty($chunk = $reader->getRecordsChunk())) {
            $this->importer->import($chunk);
        }
    }

    /**
     * @return void
     */
    public function export(): void
    {
        $this->exporter->exportToCsv();
    }
}
