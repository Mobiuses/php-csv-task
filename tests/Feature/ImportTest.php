<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Client;
use App\Services\Csv\Src\Contracts\ImporterContract;
use App\Services\Csv\Src\Contracts\ReaderContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_import_returns_a_successful_response(): void
    {

        $response = $this->get('/import');

        $response->assertStatus(200);
    }
}
