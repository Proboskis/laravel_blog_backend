<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = "permissions";

    // Relationship with User model
    public function users() {
        return $this->belongsToMany(User::class, 'user_id');
    }

    public function role_permissions() {
        return $this->belongsToMany(Role::class, 'role_id');
    }
}
