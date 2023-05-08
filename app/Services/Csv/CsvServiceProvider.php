<?php

namespace App\Services\Csv;

use App\Services\Csv\Src\Contracts\CsvServiceContract;
use App\Services\Csv\Src\Contracts\ExporterContract;
use App\Services\Csv\Src\Contracts\ImporterContract;
use App\Services\Csv\Src\Contracts\ReaderContract;
use App\Services\Csv\Src\Exporter;
use App\Services\Csv\Src\Importer;
use App\Services\Csv\Src\Reader;
use Illuminate\Support\ServiceProvider;

class CsvServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CsvServiceContract::class, CsvService::class);
        $this->app->singleton(ReaderContract::class, Reader::class);
        $this->app->singleton(ImporterContract::class, Importer::class);
        $this->app->singleton(ExporterContract::class, Exporter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
