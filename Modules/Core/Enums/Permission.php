<?php

namespace Modules\Core\Enums;

enum Permission: string
{
    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */
    case USER_VIEW = 'user.view';
    case USER_CREATE = 'user.create';
    case USER_UPDATE = 'user.update';
    case USER_DELETE = 'user.delete';

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */
    case ROLE_VIEW = 'role.view';
    case ROLE_CREATE = 'role.create';
    case ROLE_UPDATE = 'role.update';
    case ROLE_DELETE = 'role.delete';

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */
    case PERMISSION_VIEW = 'permission.view';
    case PERMISSION_CREATE = 'permission.create';
    case PERMISSION_UPDATE = 'permission.update';
    case PERMISSION_DELETE = 'permission.delete';

    /*
    |--------------------------------------------------------------------------
    | Countries
    |--------------------------------------------------------------------------
    */
    case COUNTRY_VIEW = 'country.view';
    case COUNTRY_CREATE = 'country.create';
    case COUNTRY_UPDATE = 'country.update';
    case COUNTRY_DELETE = 'country.delete';

    /*
    |--------------------------------------------------------------------------
    | Cities
    |--------------------------------------------------------------------------
    */
    case CITY_VIEW = 'city.view';
    case CITY_CREATE = 'city.create';
    case CITY_UPDATE = 'city.update';
    case CITY_DELETE = 'city.delete';

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */
    case SETTING_VIEW = 'setting.view';
    case SETTING_UPDATE = 'setting.update';

    /*
    |--------------------------------------------------------------------------
    | Devices
    |--------------------------------------------------------------------------
    */
    case DEVICE_VIEW = 'device.view';
    case DEVICE_DELETE = 'device.delete';

    /*
    |--------------------------------------------------------------------------
    | Audit Logs
    |--------------------------------------------------------------------------
    */
    case AUDIT_LOG_VIEW = 'audit-log.view';

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    case DASHBOARD_VIEW = 'dashboard.view';

    /**
     * Get all permission values.
     */
    public static function values(): array
    {
        return array_map(
            fn (self $permission) => $permission->value,
            self::cases()
        );
    }

    /**
     * Get permissions as [value => label].
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $permission) {
            $options[$permission->value] = ucwords(
                str_replace(['.', '-'], ' ', $permission->value)
            );
        }

        return $options;
    }

    /**
     * Group permissions by resource.
     */
    public static function grouped(): array
    {
        $groups = [];

        foreach (self::cases() as $permission) {
            [$resource] = explode('.', $permission->value);

            $groups[$resource][] = $permission->value;
        }

        return $groups;
    }
}
