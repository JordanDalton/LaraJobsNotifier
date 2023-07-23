<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Larajobs extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'reference_id'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    protected $fillable = [
        'title',
        'link',
        'published_at',
    ];

    protected function getReferenceIdAttribute(): int
    {
        return (int) str($this->link)->explode('/')->last();
    }
}
