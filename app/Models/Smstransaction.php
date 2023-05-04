<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smstransaction extends Model
{
    use HasFactory;

    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }

     public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function app()
    {
        return $this->belongsTo('App\Models\App');
    }

    public function template()
    {
        return $this->belongsTo('App\Models\Template');
    }
}
