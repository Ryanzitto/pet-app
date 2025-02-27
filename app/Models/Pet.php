<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specie',
        'breed',
        'age',
        'gender',
        'user_id',
        'is_neutered',
        'is_missing',
        'pet_image',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}