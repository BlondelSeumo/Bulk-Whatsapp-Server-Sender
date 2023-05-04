<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smstesttransactions extends Model
{
    use HasFactory;

    public function device()
    {
        return $this->belongsTo('App\Model\Device');
    }
}
