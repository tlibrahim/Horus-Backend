<?php

namespace Modules\Core\Enums;

enum Role: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case SUPPORT = 'support';
    case ACCOUNTING = 'accounting';

    case SHOP_OWNER = 'shop-owner';
    case SHOP_MANAGER = 'shop-manager';
    case SHOP_EMPLOYEE = 'shop-employee';

    case CUSTOMER = 'customer';
}
