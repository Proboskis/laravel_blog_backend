<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_id');
    }

    public function role_permissions(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_id');
    }
}
