<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $fillable = ['tags', 'creator_id'];

    public function taggable()
    {
        return $this->hasMany(Taggable::class, 'tag_id');
    }
}
