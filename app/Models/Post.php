<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Post
    public function posts_parent() {
        return $this->belongsTo(Post::class, 'post_parent_id');
    }

    // Relationship with Comment
    public function comments() {
        return $this->hasMany(Comment::class, 'post_id');
    }

    // Relationship with Tag
    public function post_tags() {
        return $this->belongsToMany(Tag::class, 'tag_id');
    }

    // Relationship with Category
    public function post_categories() {
        return $this->belongsToMany(Category::class, 'category_id');
    }
}
