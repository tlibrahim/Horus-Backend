<?php

declare(strict_types=1);

namespace Modules\Core\Tests\Feature;

use Modules\Core\Models\Setting;
use Modules\Core\Tests\TestCase;

final class SettingControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Setting::factory()->count(3)->create();
    }

    public function test_it_can_list_settings(): void
    {
        $response = $this->getJson('/api/v1/core/settings');

        $this->assertPaginatedResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_show_a_setting(): void
    {
        $setting = Setting::query()->firstOrFail();

        $response = $this->getJson('/api/v1/core/settings/'.$setting->id);

        $this->assertSuccessResponse($response);
        $response->assertJsonPath('data.id', $setting->id);
    }

    public function test_it_can_store_setting(): void
    {
        $response = $this->postJson('/api/v1/core/settings', [
            'key' => 'test_setting',
            'group' => 'app',
            'type' => 'string',
            'value' => 'sample',
            'description' => 'A test setting',
            'is_public' => true,
        ]);

        $this->assertSuccessResponse($response, 201);
        $this->assertDatabaseHas('settings', [
            'key' => 'test_setting',
        ]);
    }

    public function test_it_can_update_setting(): void
    {
        $setting = Setting::query()->firstOrFail();

        $response = $this->putJson('/api/v1/core/settings/'.$setting->id, [
            'key' => 'updated_setting',
            'group' => 'app',
            'type' => 'string',
            'value' => 'updated',
            'description' => 'Updated description',
            'is_public' => false,
        ]);

        $this->assertSuccessResponse($response);
        $this->assertDatabaseHas('settings', [
            'id' => $setting->id,
            'key' => 'updated_setting',
        ]);
    }

    public function test_it_can_delete_setting(): void
    {
        $setting = Setting::query()->firstOrFail();

        $response = $this->deleteJson('/api/v1/core/settings/'.$setting->id);

        $this->assertSuccessResponse($response);
        $this->assertDatabaseMissing('settings', [
            'id' => $setting->id,
        ]);
    }
}
