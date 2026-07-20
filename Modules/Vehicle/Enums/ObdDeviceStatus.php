<?php

namespace Modules\Vehicle\Enums;

enum ObdDeviceStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Retired = 'retired';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
