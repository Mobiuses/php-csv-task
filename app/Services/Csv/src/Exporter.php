<?php

namespace App\Services\Csv\Src;

use App\Models\Client;
use App\Services\Csv\Src\Contracts\ExporterContract;

class Exporter implements ExporterContract
{
    /**
     * @var int
     */
    private int $chunk = 2000;

    /**
     * @return void
     */
    public function exportToCsv(): void
    {
        $stream = $this->createStream();
        $this->setHeadeForStream($stream);

        Client::query()->chunk($this->chunk, function ($clients) use ($stream) {
            foreach ($clients as $client) {
                fputcsv($stream, [
                    $client->category,
                    $client->first_name,
                    $client->last_name,
                    $client->email,
                    $client->gender,
                    $client->birth_date,
                ]);
            }
        });

        fclose($stream);
    }

    /**
     * @return false|resource
     */
    private function createStream()
    {
        return fopen('php://output', 'w');
    }

    /**
     * @param $stream
     * @param $header
     *
     * @return void
     */
    private function setHeadeForStream($stream, $header = []): void
    {
        $header = $header ?: Client::getBaseFields();

        fputcsv($stream, $header);
    }
}
