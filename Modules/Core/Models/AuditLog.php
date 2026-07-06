<?php

namespace Modules\Core\Models;

class AuditLog extends BaseModel
{
    protected $table = 'audit_logs';

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
