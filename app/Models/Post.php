<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(Category::class,'postcategories','post_id','category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Category::class,'postcategories','post_id','category_id')->where('type','tags');
    }

     public function postcategories()
    {
        return $this->hasMany(Postcategory::class);
    }

    public function meta()
    {
        return $this->hasMany(Postmeta::class);
    }

    public function metadata()
    {
        return $this->hasMany(Postmeta::class);
    }

    public function preview()
    {
        return $this->hasOne(Postmeta::class)->where('key', 'preview');
    }

     public function banner()
    {
        return $this->hasOne(Postmeta::class)->where('key', 'banner');
    }

    public function excerpt()
    {
        return $this->hasOne(Postmeta::class)->where('key', 'excerpt');
    }

    public function metatag()
    {
        return $this->hasOne(Postmeta::class)->where('key', 'metatag');
    }

    public function metadescription()
    {
        return $this->hasOne(Postmeta::class)->where('key', 'metadescription');
    }

    public function description()
    {
        return $this->hasOne(Postmeta::class)->where('key', 'description');
    }

    public function shortDescription()
    {
        return $this->hasOne(Postmeta::class)->where('key', 'short_description');
    }
    public function longDescription()
    {
        return $this->hasOne(Postmeta::class)->where('key', 'main_description');
    }
   

    public function pageMeta()
    {
        return $this->hasOne(Postmeta::class)->where('key', 'page');
    }

    public function seo()
    {
        return $this->hasOne(Postmeta::class)->where('key', 'seo');
    }
}
