<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function roles() {
        return $this->hasMany(Role::class, 'role_id');
    }

    // Relationship with Permission
    public function permissions() {
        return $this->hasMany(Permission::class, 'permission_id');
    }
}
