<?php

declare(strict_types=1);

namespace Modules\Core\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Default API headers.
     */
    protected function apiHeaders(array $headers = []): array
    {
        return array_merge([
            'Accept' => 'application/json',
        ], $headers);
    }

    /**
     * Get a valid country payload.
     */
    protected function validCountryData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Test Country',
            'iso2' => 'TC',
            'iso3' => 'TCO',
            'phone_code' => '999',
            'currency_id' => 1,
            'language_id' => 1,
            'timezone_id' => 1,
            'nationality' => 'Test Nationality',
            'flag' => null,
            'latitude' => 30.044420,
            'longitude' => 31.235712,
            'is_active' => true,
        ], $overrides);
    }

    protected function assertValidationResponse(
        TestResponse $response,
        array $fields,
    ): void {
        $this->assertProblemResponse($response, 422);

        $errors = $response->json('error.errors');

        foreach ($fields as $field) {
            $this->assertArrayHasKey($field, $errors);
            $this->assertNotEmpty($errors[$field]);
        }
    }

    /**
     * Assert a successful API response.
     */
    protected function assertSuccessResponse(
        TestResponse $response,
        int $status = 200,
    ): void {
        $response
            ->assertStatus($status)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data',
                'meta' => [
                    'request_id',
                    'timestamp',
                    'locale',
                    'timezone',
                    'api_version',
                ],
            ]);
    }

    /**
     * Assert a paginated API response.
     */
    protected function assertPaginatedResponse(
        TestResponse $response,
        int $status = 200,
    ): void {
        $this->assertSuccessResponse($response, $status);

        $response->assertJsonStructure([
            'meta' => [
                'pagination' => [
                    'type',
                    'current_page',
                    'last_page',
                    'per_page',
                    'total',
                    'from',
                    'to',
                    'path',
                ],
            ],
        ]);
    }

    /**
     * Assert a created response.
     */
    protected function assertCreatedResponse(
        TestResponse $response,
    ): void {
        $this->assertSuccessResponse(
            $response,
            201,
        );
    }

    /**
     * Assert a deleted response.
     */
    protected function assertDeletedResponse(
        TestResponse $response,
    ): void {
        $this->assertSuccessResponse($response);

        $response->assertJson([
            'success' => true,
            'data' => null,
        ]);
    }

    /**
     * Assert an RFC7807 problem response.
     */
    protected function assertProblemResponse(
        TestResponse $response,
        int $status,
    ): void {
        $response
            ->assertStatus($status)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonStructure([
                'success',
                'error' => [
                    'type',
                    'title',
                    'status',
                    'detail',
                ],
                'meta' => [
                    'request_id',
                    'timestamp',
                    'locale',
                    'timezone',
                    'api_version',
                ],
            ]);
    }

    protected function validCurrencyData(array $overrides = []): array
    {
        return array_merge([
            'code' => 'USD',
            'symbol' => 'USD',
            'name' => 'US Dollar',
            'currency_symbol' => '$',
        ], $overrides);
    }

    protected function validLanguageData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'English',
            'code' => 'en',
            'direction' => 'ltr',
        ], $overrides);
    }

    protected function validTimezoneData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'UTC',
            'utc_offset' => '+00:00',
        ], $overrides);
    }

    protected function validCityData(array $overrides = []): array
    {
        return array_merge([
            'country_id' => 1,
            'name' => 'Cairo',
            'latitude' => 30.044400,
            'longitude' => 31.235700,
        ], $overrides);
    }

    protected function validDistrictData(array $overrides = []): array
    {
        return array_merge([
            'city_id' => 1,
            'name' => 'Nasr City',
            'postal_code' => '11765',
            'latitude' => 30.062630,
            'longitude' => 31.346600,
        ], $overrides);
    }
}
