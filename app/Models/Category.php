<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable= [ 'name','creator_id'];

    public function post(){
        return $this->hasMany(Post::class, 'category_id');
    }
}
