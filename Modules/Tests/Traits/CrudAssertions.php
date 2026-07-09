<?php

declare(strict_types=1);

namespace Modules\Tests\Traits;

use Illuminate\Testing\TestResponse;

trait CrudAssertions
{
    protected function assertCreatedResponse(TestResponse $response): void
    {
        $this->assertSuccessResponse($response, 201);
    }

    protected function assertDeletedResponse(TestResponse $response): void
    {
        $this->assertSuccessResponse($response);

        $response->assertJson([
            'success' => true,
            'data' => null,
        ]);
    }
}
