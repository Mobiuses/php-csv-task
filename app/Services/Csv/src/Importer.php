<?php

namespace App\Services\Csv\Src;

use App\ORM\Managers\Contracts\ClientManagerContract;
use App\Services\Csv\Src\Contracts\ImporterContract;

class Importer implements ImporterContract
{
    /**
     * @var array
     */
    private array $mapping = [];

    /**
     * @param  ClientManagerContract  $clientManager
     */
    public function __construct(
        private ClientManagerContract $clientManager
    ) {
    }

    /**
     * @param $dataChunkFromCsv
     *
     * @return void
     */
    public function import($dataChunkFromCsv): void
    {
        $this->clientManager->bulkInsert(
            $this->prepareChunkWithMapping($dataChunkFromCsv)
        );
    }

    /**
     * @param  array  $chunk
     *
     * @return array
     */
    private function prepareChunkWithMapping(array $chunk): array
    {
        foreach ($chunk as &$row) {
            $row = array_combine($this->mapping, $row);
        }

        return $chunk;
    }

    /**
     * @return bool
     */
    public function isMappingNotSet(): bool
    {
        return empty($this->mapping);
    }

    /**
     * @param  array  $mapping
     *
     * @return $this
     */
    public function setMapping(array $mapping): self
    {
        $this->mapping = $mapping;

        return $this;
    }
}
