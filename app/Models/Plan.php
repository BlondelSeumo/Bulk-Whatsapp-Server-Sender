<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $casts=[
        'data'=>'json'
    ];

    public function activeuser()
    {
        return $this->hasMany('App\Models\User');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
