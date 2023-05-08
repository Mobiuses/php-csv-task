<?php

namespace App\Services\Csv\Src;

use App\Services\Csv\Src\Contracts\ReaderContract;
use SplFileObject;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class Reader implements ReaderContract
{
    /**
     * @var string
     */
    private string $delimiter = ',';
    /**
     * @var bool
     */
    private bool $withHeader;
    /**
     * @var array
     */
    private array $header;
    /**
     * @var int
     */
    private int $chunkMax = 100;
    /**
     * @var SplFileObject
     */
    private SplFileObject $file;

    /**
     * @param  string  $filePath
     * @param  bool  $withHeader
     *
     * @return $this
     */
    public function readFromFile(string $filePath, bool $withHeader = true): self
    {
        if ( ! file_exists($filePath)) {
            throw new FileNotFoundException($filePath);
        }

        $this->withHeader = $withHeader;

        $file = new SplFileObject($filePath);
        $file->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY |
            SplFileObject::READ_AHEAD |
            SplFileObject::DROP_NEW_LINE
        );
        $file->setCsvControl($this->delimiter);
        $this->file = $file;

        if ($this->withHeader) {
            $this->initHeader();
        }

        return $this;
    }

    /**
     * @param  int|null  $chunkMax
     *
     * @return array
     * @throws \Exception
     */
    public function getRecordsChunk(int $chunkMax = null): array
    {
        if ($this->isFileNotInitialized()) {
            throw new \Exception('File is not initialized.');
        }

        if ($chunkMax) {
            $this->chunkMax = $chunkMax;
        }

        $chunk      = [];
        $chunkCount = 0;
        while ( ! $this->file->eof()) {
            if ($chunkCount === $this->chunkMax) {
                break;
            }
            $chunk[] = $this->file->current();
            $this->file->next();
            $chunkCount++;
        }

        return $chunk;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @return array
     */
    public function getMapping(): array
    {
        return $this->header;
    }

    /**
     * @param  array  $mapping
     *
     * @return $this
     * @throws \Exception
     */
    public function setHeaderMapping(array $mapping): self
    {
        if (count($mapping) !== $this->getHeader()) {
            throw new \Exception('Wrong header mapping');
        }

        $this->headerMapping = $mapping;

        return $this;
    }

    /**
     * @return bool
     */
    private function isFileNotInitialized(): bool
    {
        return empty($this->file);
    }

    /**
     * @return void
     */
    private function initHeader(): void
    {
        $this->file->rewind();
        $this->header = $this->file->current();;
        $this->file->next();
    }
}
