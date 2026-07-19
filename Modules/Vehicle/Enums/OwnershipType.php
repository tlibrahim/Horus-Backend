<?php

declare(strict_types=1);

namespace Modules\Vehicle\Enums;

enum OwnershipType: string
{
    case OWNER = 'owner';

    case PRIMARY_DRIVER = 'primary_driver';

    case SECONDARY_DRIVER = 'secondary_driver';

    case COMPANY = 'company';

    case LEASE = 'lease';

    case FINANCE = 'finance';

    case FLEET_MANAGER = 'fleet_manager';
}
