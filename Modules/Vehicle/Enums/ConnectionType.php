<?php

namespace Modules\Vehicle\Enums;

enum ConnectionType: string
{
    case Bluetooth = 'bluetooth';
    case Wifi = 'wifi';
    case Gsm = 'gsm';
    case Usb = 'usb';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
