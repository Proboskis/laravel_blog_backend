<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = "user_roles";

    // Relationship with User
    public function users() {
        return $this->hasMany(Post::class, 'user_id');
    }

    // Relationship with Role
    public function roles() {
        return $this->hasMany(Tag::class, 'role_id');
    }

}
