<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'status',
        'featured_image',
        'id',
        'created_at',
        'updated_at',
        'tags'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}