<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = "roles";

    // Relationship with UserRoles
    public function user_roles() {
        return $this->belongsToMany(Post::class, 'user_id');
    }

    // Relationship with UserRoles
    public function role_permissions() {
        return $this->belongsToMany(Permission::class, 'permission_id');
    }
}
