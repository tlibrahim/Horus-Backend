<?php

declare(strict_types=1);

namespace Modules\Core\Tests\Feature;

use Modules\Core\Models\Language;
use Modules\Core\Tests\TestCase;

final class LanguageControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_it_can_list_languages(): void
    {
        $response = $this->getJson(
            route('api.v1.core.languages.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_return_language_options(): void
    {
        $response = $this->getJson(
            route('api.v1.core.languages.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_show_a_language(): void
    {
        $language = Language::query()->firstOrFail();

        $response = $this->getJson(
            route(
                'api.v1.core.languages.show',
                $language
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath(
            'data.id',
            $language->id,
        );
    }

    public function test_it_returns_not_found_for_unknown_language(): void
    {
        $response = $this->getJson(
            route(
                'api.v1.core.languages.show',
                999999,
            ),
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }

    public function test_it_can_store_language(): void
    {
        $response = $this->postJson(
            route('api.v1.core.languages.store'),
            $this->validLanguageData([
                'name' => 'French',
                'code' => 'fr',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('languages', [
            'name' => 'French',
            'code' => 'fr',
        ]);
    }

    public function test_it_validates_store_request(): void
    {
        $response = $this->postJson(
            route('api.v1.core.languages.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'name',
            'code',
            'direction',
        ]);
    }

    public function test_it_can_update_language(): void
    {
        $language = Language::query()->firstOrFail();

        $response = $this->putJson(
            route(
                'api.v1.core.languages.update',
                $language
            ),
            $this->validLanguageData([
                'name' => 'Updated Language Name',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('languages', [
            'id' => $language->id,
            'name' => 'Updated Language Name',
        ]);
    }

    public function test_it_validates_update_request(): void
    {
        $language = Language::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.core.languages.update', $language),
            [
                'name' => '',
            ],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'name',
            'code',
            'direction',
        ]);
    }

    public function test_it_can_toggle_language_status(): void
    {
        $language = Language::query()->firstOrFail();

        $response = $this->patchJson(
            route(
                'api.v1.core.languages.toggleStatus',
                $language
            ),
            ['is_active' => ! $language->is_active],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('languages', [
            'id' => $language->id,
            'is_active' => ! $language->is_active,
        ]);
    }

    public function test_it_can_activate_language(): void
    {
        $language = Language::query()->firstOrFail();

        $language->update([
            'is_active' => false,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.languages.toggleStatus', $language),
            [
                'is_active' => true,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('languages', [
            'id' => $language->id,
            'is_active' => true,
        ]);
    }

    public function test_it_can_deactivate_language(): void
    {
        $language = Language::query()->firstOrFail();

        $language->update([
            'is_active' => true,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.languages.toggleStatus', $language),
            [
                'is_active' => false,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('languages', [
            'id' => $language->id,
            'is_active' => false,
        ]);
    }

    public function test_it_can_delete_language(): void
    {
        $language = Language::query()->firstOrFail();

        $response = $this->deleteJson(
            route('api.v1.core.languages.destroy', $language),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('languages', [
            'id' => $language->id,
        ]);
    }

    public function test_it_returns_404_when_deleting_unknown_language(): void
    {
        $response = $this->deleteJson(
            route('api.v1.core.languages.destroy', 999999),
            [],
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }
}
