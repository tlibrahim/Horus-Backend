<?php

namespace Modules\Core\Tests\Unit;

use App\Support\Contracts\ActivatableServiceInterface;
use App\Support\Contracts\CrudServiceInterface;
use Modules\Core\Contracts\Settings\Services\SettingServiceInterface;
use PHPUnit\Framework\TestCase;

class ServiceContractTest extends TestCase
{
    public function test_crud_service_interface_exposes_only_common_crud_operations(): void
    {
        $methods = get_class_methods(CrudServiceInterface::class);

        $this->assertContains('all', $methods);
        $this->assertContains('paginate', $methods);
        $this->assertContains('options', $methods);
        $this->assertContains('find', $methods);
        $this->assertContains('create', $methods);
        $this->assertContains('update', $methods);
        $this->assertContains('delete', $methods);
        $this->assertNotContains('toggleStatus', $methods);
    }

    public function test_activatable_service_interface_exposes_status_operations(): void
    {
        $methods = get_class_methods(ActivatableServiceInterface::class);

        $this->assertContains('toggleStatus', $methods);
        $this->assertContains('activate', $methods);
        $this->assertContains('deactivate', $methods);
    }

    public function test_setting_service_interface_is_not_forced_to_implement_status_toggle(): void
    {
        $methods = get_class_methods(SettingServiceInterface::class);

        $this->assertContains('all', $methods);
        $this->assertNotContains('toggleStatus', $methods);
        $this->assertNotContains('activate', $methods);
        $this->assertNotContains('deactivate', $methods);
    }
}
