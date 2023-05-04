<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postcategory extends Model
{
    use HasFactory;

     public function Category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function post()
    {
        return $this->belongsToMany(Post::class);
    }
}
