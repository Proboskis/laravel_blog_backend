<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostMeta extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = "post_metas";

    protected $fillable = [
        'post_id',
        'meta_key',
        'meta_value'
    ];

    // Relationship with Post
    public function posts(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
