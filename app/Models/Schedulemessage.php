<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedulemessage extends Model
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

    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }

    public function template()
    {
        return $this->belongsTo('App\Models\Template');
    }

    public function contacts()
    {
        return $this->belongsToMany('App\Models\Contact','schedulecontacts','schedulemessage_id','contact_id');
    }
}
