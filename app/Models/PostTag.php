<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostTag extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = "post_tags";

    // Relationship with Post
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_id');
    }

    // Relationship with Tag
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class, 'tag_id');
    }
}
