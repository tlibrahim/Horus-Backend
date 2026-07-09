<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\IAM\Models\User;

/** @mixin User */
final class UserResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'display_name' => $this->display_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'is_active' => (bool) $this->is_active,
            'is_verified' => (bool) $this->is_verified,
            'email_verified_at' => $this->formatDate($this->email_verified_at),
            'mobile_verified_at' => $this->formatDate($this->mobile_verified_at),
            'last_login_at' => $this->formatDate($this->last_login_at),
            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }
}
