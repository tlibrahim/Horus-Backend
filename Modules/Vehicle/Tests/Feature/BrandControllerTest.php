<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature;

use Modules\Vehicle\Models\Brand;
use Modules\Vehicle\Tests\TestCase;

final class BrandControllerTest extends TestCase
{
    public function test_it_can_list_brands(): void
    {
        $response = $this->getJson(
            route('api.v1.vehicle.brands.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_return_brand_options(): void
    {
        $response = $this->getJson(
            route('api.v1.vehicle.brands.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_show_a_brand(): void
    {
        $brand = Brand::query()->firstOrFail();

        $response = $this->getJson(
            route('api.v1.vehicle.brands.show', $brand),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
        $response->assertJsonPath('data.id', $brand->id);
    }

    public function test_it_can_store_brand(): void
    {
        $response = $this->postJson(
            route('api.v1.vehicle.brands.store'),
            $this->validBrandData([
                'name' => 'Mazda',
                'slug' => 'mazda',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('brands', [
            'slug' => 'mazda',
            'name' => 'Mazda',
        ]);
    }

    public function test_it_validates_brand_store_request(): void
    {
        $response = $this->postJson(
            route('api.v1.vehicle.brands.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, ['name', 'slug']);
    }

    public function test_it_can_update_brand(): void
    {
        $brand = Brand::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.vehicle.brands.update', $brand),
            $this->validBrandData([
                'name' => 'Updated Brand',
                'slug' => 'updated-brand',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('brands', [
            'id' => $brand->id,
            'name' => 'Updated Brand',
            'slug' => 'updated-brand',
        ]);
    }

    public function test_it_can_toggle_brand_status(): void
    {
        $brand = Brand::query()->firstOrFail();

        $response = $this->patchJson(
            route('api.v1.vehicle.brands.toggleStatus', $brand),
            ['is_active' => ! $brand->is_active],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('brands', [
            'id' => $brand->id,
            'is_active' => ! $brand->is_active,
        ]);
    }

    public function test_it_can_delete_brand(): void
    {
        $brand = Brand::query()->whereDoesntHave('models')->firstOrFail();

        $response = $this->deleteJson(
            route('api.v1.vehicle.brands.destroy', $brand),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('brands', [
            'id' => $brand->id,
        ]);
    }
}
