<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function posts() {
        return $this->hasMany(Post::class, 'post_id');
    }

    // Relationship with Tag
    public function tags() {
        return $this->hasMany(Tag::class, 'tag_id');
    }
}
