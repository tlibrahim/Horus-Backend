<?php

declare(strict_types=1);

namespace Modules\OBD\Enums;

enum ObdSessionStatus: string
{
    case Connecting = 'connecting';

    case Connected = 'connected';

    case Disconnected = 'disconnected';

    case Failed = 'failed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::Connecting => 'Connecting',
            self::Connected => 'Connected',
            self::Disconnected => 'Disconnected',
            self::Failed => 'Failed',
        };
    }

    public function isActive(): bool
    {
        return match ($this) {
            self::Connecting,
            self::Connected => true,

            self::Disconnected,
            self::Failed => false,
        };
    }

    public function isClosed(): bool
    {
        return ! $this->isActive();
    }
}
