<?php

namespace Modules\IAM\Models;

class UserRole extends BaseModel
{
    protected $table = 'user_roles';

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = null;
}
