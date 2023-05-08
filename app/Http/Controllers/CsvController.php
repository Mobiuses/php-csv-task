<?php

namespace App\Http\Controllers;

use App\Services\Csv\Src\Contracts\CsvServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvController extends Controller
{
    /**
     * @param  CsvServiceContract  $csvService
     */
    public function __construct(
        private CsvServiceContract $csvService
    ) {
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function import()
    {
        $this->csvService->importClientsCsvToDB(storage_path('datasets/dataset.txt'));

        return view('import_done');
    }

    /**
     * @return StreamedResponse
     */
    public function export(): StreamedResponse
    {
        return new StreamedResponse(function () {
            $this->csvService->export();
        }, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="export.csv"',
        ]);
    }
}
