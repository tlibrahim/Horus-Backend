<?php

declare(strict_types=1);

namespace Modules\Core\Tests\Feature;

use Modules\Core\Models\FeatureFlag;
use Modules\Core\Tests\TestCase;

final class FeatureFlagControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        FeatureFlag::factory()->count(3)->create();
    }

    public function test_it_can_list_feature_flags(): void
    {
        $response = $this->getJson('/api/v1/core/feature-flags');

        $this->assertPaginatedResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_show_a_feature_flag(): void
    {
        $featureFlag = FeatureFlag::query()->firstOrFail();

        $response = $this->getJson('/api/v1/core/feature-flags/'.$featureFlag->id);

        $this->assertSuccessResponse($response);

        $response->assertJsonPath('data.id', $featureFlag->id);
    }

    public function test_it_can_store_feature_flag(): void
    {
        $response = $this->postJson('/api/v1/core/feature-flags', [
            'key' => 'vehicle.diagnostics',
            'enabled' => true,
            'description' => 'Vehicle diagnostics feature',
        ]);

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('feature_flags', [
            'key' => 'vehicle.diagnostics',
            'enabled' => true,
        ]);
    }

    public function test_it_can_update_feature_flag(): void
    {
        $featureFlag = FeatureFlag::query()->firstOrFail();

        $response = $this->putJson('/api/v1/core/feature-flags/'.$featureFlag->id, [
            'key' => 'vehicle.ai',
            'enabled' => false,
            'description' => 'Updated feature',
        ]);

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('feature_flags', [
            'id' => $featureFlag->id,
            'key' => 'vehicle.ai',
            'enabled' => false,
        ]);
    }

    public function test_it_can_delete_feature_flag(): void
    {
        $featureFlag = FeatureFlag::query()->firstOrFail();

        $response = $this->deleteJson('/api/v1/core/feature-flags/'.$featureFlag->id);

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('feature_flags', [
            'id' => $featureFlag->id,
        ]);
    }

    public function test_it_can_find_feature_flag_by_key(): void
    {
        $featureFlag = FeatureFlag::query()->firstOrFail();

        $response = $this->getJson('/api/v1/core/feature-flags/key/'.$featureFlag->key);

        $this->assertSuccessResponse($response);

        $response->assertJsonPath('data.key', $featureFlag->key);
    }

    public function test_it_can_list_enabled_feature_flags(): void
    {
        FeatureFlag::factory()->enabled()->count(2)->create();

        $response = $this->getJson('/api/v1/core/feature-flags/enabled');

        $this->assertSuccessResponse($response);
    }

    public function test_it_can_list_disabled_feature_flags(): void
    {
        FeatureFlag::factory()->disabled()->count(2)->create();

        $response = $this->getJson('/api/v1/core/feature-flags/disabled');

        $this->assertSuccessResponse($response);
    }

    public function test_it_can_enable_feature_flag(): void
    {
        $featureFlag = FeatureFlag::factory()->disabled()->create();

        $response = $this->patchJson(
            '/api/v1/core/feature-flags/'.$featureFlag->id.'/enable'
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('feature_flags', [
            'id' => $featureFlag->id,
            'enabled' => true,
        ]);
    }

    public function test_it_can_disable_feature_flag(): void
    {
        $featureFlag = FeatureFlag::factory()->enabled()->create();

        $response = $this->patchJson(
            '/api/v1/core/feature-flags/'.$featureFlag->id.'/disable'
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('feature_flags', [
            'id' => $featureFlag->id,
            'enabled' => false,
        ]);
    }
}
