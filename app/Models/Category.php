<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'status',
        'type',
        'is_featured',
        'lang',
    ];

    public function postcategory()
    {
        return $this->belongsTo(Postcategory::class);
    }

    public function postcategories()
    {
        return $this->hasMany(Postcategory::class);
    }

    public function posts()
    {
         return $this->belongsToMany('App\Models\Post','postcategories','post_id','category_id');
    }
}
