<?php

namespace Modules\Auth\Models;

class RolePermission extends BaseModel
{
    protected $table = 'role_permissions';

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = null;
}
