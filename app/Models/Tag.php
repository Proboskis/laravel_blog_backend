<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function post_tags() {
        return $this->belongsToMany(Post::class, 'post_id');
    }
}
