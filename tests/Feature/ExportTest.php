<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_export_returns_a_successful_response(): void
    {
        $response = $this->get('/import');
        $response->assertStatus(200);

        $response = $this->get('/export');
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $response->assertHeader('Content-Disposition', 'attachment; filename="export.csv"');
        $response->assertStatus(200);
        $response->assertDownload('export.csv');
    }
}
