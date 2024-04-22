<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_id',
        'taggable_id',
        'taggable_type'
    ];

    public function tags()
    {
        return $this->belongsTo(Tags::class, 'tag_id');
    }

    public function taggable()
    {
        return $this->morphTo();
    }
}

