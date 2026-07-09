<?php

namespace Modules\IAM\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    protected $guarded = [];

    protected $perPage = 20;
}
