<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = "categories";

    protected $fillable = [
        'category_parent_id',
        'title',
        'meta_title',
        'slug',
        'content'
    ];

    // Relationship with PostCategory
    public function post_categories(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_id');
    }
}
