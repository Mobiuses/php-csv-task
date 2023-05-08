<?php

namespace App\Services\Csv\Src\Contracts;

interface ReaderContract
{
    /**
     * @param  string  $filePath
     * @param  bool  $withHeader
     *
     * @return $this
     */
    public function readFromFile(string $filePath, bool $withHeader = true): self;

    /**
     * @return array
     */
    public function getRecordsChunk(): array;
}
