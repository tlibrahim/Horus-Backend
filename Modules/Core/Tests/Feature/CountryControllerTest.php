<?php

declare(strict_types=1);

namespace Modules\Core\Tests\Feature;

use Modules\Core\Models\Country;
use Modules\Core\Tests\TestCase;

final class CountryControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_it_can_list_countries(): void
    {
        $response = $this->getJson(
            route('api.v1.core.countries.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_return_country_options(): void
    {
        $response = $this->getJson(
            route('api.v1.core.countries.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_show_a_country(): void
    {
        $country = Country::query()->firstOrFail();

        $response = $this->getJson(
            route(
                'api.v1.core.countries.show',
                $country
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath(
            'data.id',
            $country->id,
        );
    }

    public function test_it_returns_not_found_for_unknown_country(): void
    {
        $response = $this->getJson(
            route(
                'api.v1.core.countries.show',
                999999,
            ),
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }

    public function test_it_can_store_country(): void
    {
        $response = $this->postJson(
            route('api.v1.core.countries.store'),
            $this->validCountryData([
                'iso2' => 'AA',
                'iso3' => 'AAA',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('countries', [
            'iso2' => 'AA',
            'iso3' => 'AAA',
        ]);
    }

    public function test_it_validates_store_request(): void
    {
        $response = $this->postJson(
            route('api.v1.core.countries.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'name',
            'iso2',
            'iso3',
            'phone_code',
            'currency_id',
            'language_id',
            'timezone_id',
            'nationality',
        ]);
    }

    public function test_it_can_update_country(): void
    {
        $country = Country::query()->firstOrFail();

        $response = $this->putJson(
            route(
                'api.v1.core.countries.update',
                $country
            ),
            $this->validCountryData([
                'name' => 'Updated Country Name',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('countries', [
            'id' => $country->id,
            'name' => 'Updated Country Name',
        ]);
    }

    public function test_it_validates_update_request(): void
    {
        $country = Country::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.core.countries.update', $country),
            [
                'name' => '',
            ],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'name',
            'iso2',
            'iso3',
            'phone_code',
            'currency_id',
            'language_id',
            'timezone_id',
            'nationality',
        ]);

    }

    public function test_it_can_toggle_country_status(): void
    {
        $country = Country::query()->firstOrFail();

        $response = $this->patchJson(
            route(
                'api.v1.core.countries.toggleStatus',
                $country
            ),
            ['is_active' => ! $country->is_active],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('countries', [
            'id' => $country->id,
            'is_active' => ! $country->is_active,
        ]);
    }

    public function test_it_can_activate_country(): void
    {
        $country = Country::query()->firstOrFail();

        $country->update([
            'is_active' => false,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.countries.toggleStatus', $country),
            [
                'is_active' => true,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('countries', [
            'id' => $country->id,
            'is_active' => true,
        ]);
    }

    public function test_it_can_deactivate_country(): void
    {
        $country = Country::query()->firstOrFail();

        $country->update([
            'is_active' => true,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.countries.toggleStatus', $country),
            [
                'is_active' => false,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('countries', [
            'id' => $country->id,
            'is_active' => false,
        ]);
    }

    public function test_it_can_delete_country(): void
    {
        $country = Country::query()->firstOrFail();

        $response = $this->deleteJson(
            route('api.v1.core.countries.destroy', $country),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('countries', [
            'id' => $country->id,
        ]);
    }

    public function test_it_returns_404_when_deleting_unknown_country(): void
    {
        $response = $this->deleteJson(
            route('api.v1.core.countries.destroy', 999999),
            [],
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }
}
