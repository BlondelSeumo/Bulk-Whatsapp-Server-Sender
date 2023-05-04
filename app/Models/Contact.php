<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

   

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function schedulecontacts()
    {
        return $this->hasMany('App\Models\Schedulecontact');
    }
}
