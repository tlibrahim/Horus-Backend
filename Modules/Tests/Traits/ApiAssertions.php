<?php

declare(strict_types=1);

namespace Modules\Tests\Traits;

use Illuminate\Testing\TestResponse;

trait ApiAssertions
{
    protected function assertSuccessResponse(
        TestResponse $response,
        int $status = 200,
    ): void {
        $response
            ->assertStatus($status)
            ->assertJson([
                'success' => true,
            ]);
    }

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

    protected function assertValidationResponse(
        TestResponse $response,
        array $fields,
    ): void {
        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);

        $errors = $response->json('error.errors');

        foreach ($fields as $field) {
            $this->assertArrayHasKey($field, $errors);
            $this->assertNotEmpty($errors[$field]);
        }
    }
}
