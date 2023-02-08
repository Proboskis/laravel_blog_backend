<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = "tags";

    protected $fillable = [
        'title',
        'meta_title',
        'slug',
        'content'
    ];

    // Relationship with PostTag
    public function post_tags(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_id');
    }
}
