<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = "comments";

    protected $fillable = [
        'post_id',
        'comment_parent_id',
        'title',
        'published',
        'content'
    ];

    // Relationship with Post
    public function posts(): BelongsTo
    {
        return $this->belongsTo(User::class, 'post_id');
    }

    // RelationShip with Comment
    public function comments_parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'comment_parent_id');
    }
}
