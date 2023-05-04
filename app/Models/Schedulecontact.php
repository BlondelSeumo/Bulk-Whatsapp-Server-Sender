<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedulecontact extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function contact()
    {
        return $this->belongsTo('App\Models\Contact');
    }
}
