<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = "posts";

    protected $fillable = [
        'user_id',
        'post_parent_id',
        'title',
        'meta_title',
        'slug',
        'summary',
        'published',
        'content'
    ];

    // Relationship with User
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Post
    public function posts_parent(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_parent_id');
    }

    // Relationship with Comment
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    // Relationship with Tag
    public function post_tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tag_id');
    }

    // Relationship with Category
    public function post_categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_id');
    }
}
