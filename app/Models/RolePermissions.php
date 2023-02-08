<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RolePermissions extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = "role_permissions";

    // Relationship with Role
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'role_id');
    }

    // Relationship with Permission
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'permission_id');
    }
}
