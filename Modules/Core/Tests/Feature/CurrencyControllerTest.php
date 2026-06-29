<?php

declare(strict_types=1);

namespace Modules\Core\Tests\Feature;

use Modules\Core\Models\Currency;
use Modules\Core\Tests\TestCase;

final class CurrencyControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_it_can_list_currencies(): void
    {
        $response = $this->getJson(
            route('api.v1.core.currencies.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_return_currency_options(): void
    {
        $response = $this->getJson(
            route('api.v1.core.currencies.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_show_a_currency(): void
    {
        $currency = Currency::query()->firstOrFail();

        $response = $this->getJson(
            route(
                'api.v1.core.currencies.show',
                $currency
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath(
            'data.id',
            $currency->id,
        );
    }

    public function test_it_returns_not_found_for_unknown_currency(): void
    {
        $response = $this->getJson(
            route(
                'api.v1.core.currencies.show',
                999999,
            ),
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }

    public function test_it_can_store_currency(): void
    {
        $response = $this->postJson(
            route('api.v1.core.currencies.store'),
            $this->validCurrencyData([
                'name' => 'AA',
                'code' => 'AAA',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('currencies', [
            'name' => 'AA',
            'code' => 'AAA',
        ]);
    }

    public function test_it_validates_store_request(): void
    {
        $response = $this->postJson(
            route('api.v1.core.currencies.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'name',
            'code',
            'symbol',
            'currency_symbol',
        ]);
    }

    public function test_it_can_update_currency(): void
    {
        $currency = Currency::query()->firstOrFail();

        $response = $this->putJson(
            route(
                'api.v1.core.currencies.update',
                $currency
            ),
            $this->validCurrencyData([
                'name' => 'Updated Currency Name',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('currencies', [
            'id' => $currency->id,
            'name' => 'Updated Currency Name',
        ]);
    }

    public function test_it_validates_update_request(): void
    {
        $currency = Currency::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.core.currencies.update', $currency),
            [
                'name' => '',
            ],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'name',
            'code',
            'symbol',
            'currency_symbol',
        ]);

    }

    public function test_it_can_toggle_currency_status(): void
    {
        $currency = Currency::query()->firstOrFail();

        $response = $this->patchJson(
            route(
                'api.v1.core.currencies.toggleStatus',
                $currency
            ),
            ['is_active' => ! $currency->is_active],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('currencies', [
            'id' => $currency->id,
            'is_active' => ! $currency->is_active,
        ]);
    }

    public function test_it_can_activate_currency(): void
    {
        $currency = Currency::query()->firstOrFail();

        $currency->update([
            'is_active' => false,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.currencies.toggleStatus', $currency),
            [
                'is_active' => true,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('currencies', [
            'id' => $currency->id,
            'is_active' => true,
        ]);
    }

    public function test_it_can_deactivate_currency(): void
    {
        $currency = Currency::query()->firstOrFail();

        $currency->update([
            'is_active' => true,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.currencies.toggleStatus', $currency),
            [
                'is_active' => false,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('currencies', [
            'id' => $currency->id,
            'is_active' => false,
        ]);
    }

    public function test_it_can_delete_currency(): void
    {
        $currency = Currency::query()->firstOrFail();

        $response = $this->deleteJson(
            route('api.v1.core.currencies.destroy', $currency),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('currencies', [
            'id' => $currency->id,
        ]);
    }

    public function test_it_returns_404_when_deleting_unknown_currency(): void
    {
        $response = $this->deleteJson(
            route('api.v1.core.currencies.destroy', 999999),
            [],
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }
}
