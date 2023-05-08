<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\ClientController;
use App\Http\Filters\ClientFilter;
use App\Http\Resources\ClientResource;
use App\ORM\Enums\ClientGenderEnum;
use App\ORM\Repositories\Contracts\ClientRepositoryContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiClientsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * test_get_clients_list_without_filters
     */
    public function test_get_clients_list_without_filters(): void
    {
        $response = $this->get('/api/clients');

        $actualResponse   = $response->getContent();
        $expectedResponse = $this->getClients();

        $this->assertEquals($expectedResponse, $actualResponse);

        $response->assertStatus(200);
    }

    /**
     * test_get_clients_list_filter_pagination
     */
    public function test_get_clients_list_filter_pagination(): void
    {
        $response = $this->get("/api/clients?page=1");

        $actualResponse   = $response->getContent();
        $expectedResponse = $this->getClients();

        $this->assertEquals($expectedResponse, $actualResponse);
        $response->assertStatus(200);

        $response = $this->get("/api/clients?page=3");

        $actualResponse   = $response->getContent();
        $expectedResponse = $this->getClients(page: 3);

        $this->assertEquals($expectedResponse, $actualResponse);
        $response->assertStatus(200);

        $response = $this->get("/api/clients?page=3");

        $actualResponse   = $response->getContent();
        $expectedResponse = $this->getClients();

        $this->assertEquals($expectedResponse, $actualResponse);
        $response->assertStatus(200);

    }

    /**
     * test_get_clients_list_filter_category
     */
    public function test_get_clients_list_filter_category(): void
    {
        $categories = ['toys', 'films'];

        foreach ($categories as $category) {
            $response = $this->get("/api/clients?category=$category");

            $actualResponse   = $response->getContent();
            $expectedResponse = $this->getClients(['category' => $category]);

            $this->assertEquals($expectedResponse, $actualResponse);
            $response->assertStatus(200);
        }
    }

    /**
     * test_get_clients_list_filter_category
     */
    public function test_get_clients_list_filter_gender(): void
    {
        foreach (ClientGenderEnum::values() as $gender) {
            $response = $this->get("/api/clients?gender=$gender");

            $actualResponse   = $response->getContent();
            $expectedResponse = $this->getClients(['gender' => $gender]);

            $this->assertEquals($expectedResponse, $actualResponse);
            $response->assertStatus(200);
        }
    }

    /**
     * test_get_clients_list_filter_ages
     */
    public function test_get_clients_list_filter_ages(): void
    {
        $ages = [25, 23, 45, 19, 12];

        foreach ($ages as $age) {
            $response = $this->get("/api/clients?age=$age");

            $actualResponse   = $response->getContent();
            $expectedResponse = $this->getClients(['age' => $age]);

            $this->assertEquals($expectedResponse, $actualResponse);
            $response->assertStatus(200);
        }
    }

    /**
     * test_get_clients_list_filter_age_before_and_age_after
     */
    public function test_get_clients_list_filter_age_before_and_age_after(): void
    {
        $ages = [
            [34, 21],
            [21, 20],
            [46, 21],
        ];

        foreach ($ages as $age) {
            $response = $this->get("/api/clients?age_before=$age[0]&age_after=$age[1]");

            $actualResponse   = $response->getContent();
            $expectedResponse = $this->getClients(['age_before' => $age[0], 'age_after' => $age[1]]);

            $this->assertEquals($expectedResponse, $actualResponse);
            $response->assertStatus(200);
        }
    }

    /**
     * test_get_clients_list_filter_birth_date
     */
    public function test_get_clients_list_filter_birth_date(): void
    {
        $birthDates = [
            '1996-02-27',
            '2001-01-21',
            '1977-05-02',
        ];

        foreach ($birthDates as $date) {
            $response = $this->get("/api/clients?birth_date=$date");

            $actualResponse   = $response->getContent();
            $expectedResponse = $this->getClients(['birth_date' => $date]);

            $this->assertEquals($expectedResponse, $actualResponse);
            $response->assertStatus(200);
        }
    }

    /**
     * test_get_clients_list_filter_age_before_and_age_after_validation
     */
    public function test_get_clients_list_filter_age_before_and_age_after_validation(): void
    {
        $ages = [
            [34, 21],
            [21, 20],
            [46, 21],
            [0, 35],
            ['sadasd', 35],
            ['sadasd', 35],
            [-1, 2],
        ];

        foreach ($ages as $age) {
            $response = $this->getJson("/api/clients?age_after=$age[0]&age_before=$age[1]");

            $response->assertStatus(422);
            $response->assertJsonValidationErrors(['age_after']);
        }
    }

    /**
     * test_get_clients_list_filter_category
     */
    public function test_get_clients_list_filter_category_validation(): void
    {
        $categories = [-1, 0];

        foreach ($categories as $category) {
            $response = $this->getJson("/api/clients?category=$category");

            $response->assertStatus(422);
            $response->assertJsonValidationErrors(['category']);
        }
    }

    /**
     * test_get_clients_list_filter_gender_validation
     */
    public function test_get_clients_list_filter_gender_validation(): void
    {
        $genders = [-1, 0, 'asdas', '0', 'ffemale'];

        foreach ($genders as $gender) {
            $response = $this->getJson("/api/clients?gender=$gender");

            $response->assertStatus(422);
            $response->assertJsonValidationErrors(['gender']);
        }
    }

    /**
     * test_get_clients_list_filter_age_validation
     */
    public function test_get_clients_list_filter_age_validation(): void
    {
        $ages = [-1, 0, 'asdas', '0', 201,];

        foreach ($ages as $age) {
            $response = $this->getJson("/api/clients?age=$age");

            $response->assertStatus(422);
            $response->assertJsonValidationErrors(['age']);
        }

        $response = $this->getJson("/api/clients?age=25&age_after=34");

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['age']);
    }

    /**
     * test_get_clients_list_filter_age_validation
     */
    public function test_get_clients_list_filter_age_after_validation(): void
    {
        $response = $this->getJson("/api/clients?age_after=19");

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['age_after']);
    }

    /**
     * test_get_clients_list_filter_age_validation
     */
    public function test_get_clients_list_filter_age_before_validation(): void
    {
        $response = $this->getJson("/api/clients?age_before=25");

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['age_after']);
    }

    /**
     * test_get_clients_list_filter_birth_date_validation
     */
    public function test_get_clients_list_filter_birth_date_validation(): void
    {
        $birthDates = [
            '72-07-04',
            '1972-13-04',
            '1972-07-4',
        ];

        foreach ($birthDates as $date) {
            $response = $this->getJson("/api/clients?birth_date=$date");

            $response->assertStatus(422);
            $response->assertJsonValidationErrors(['birth_date']);
        }
    }

    /**
     * @param  array  $params
     * @param  int|null  $page
     * @param  int|null  $perPage
     *
     * @return false|string
     */
    private function getClients(array $params = [], int $page = null, int $perPage = null)
    {
        $filterQuery = (new ClientFilter())->getQueryFromData(data: $params);
        $data = app(ClientRepositoryContract::class)
            ->getList(
                $filterQuery,
                $perPage ?: ClientController::PER_PAGE_DEFAULT,
                $page
            );

        return ClientResource::collection($data)->toResponse(request())->getContent();
    }
}
