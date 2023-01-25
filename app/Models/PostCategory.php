<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = "post_categories";

    // Relationship with Post
    public function posts() {
        return $this->hasMany(Post::class, 'post_id');
    }

    // Relationship with Category
    public function tags() {
        return $this->hasMany(Category::class, 'categories_id');
    }
}
