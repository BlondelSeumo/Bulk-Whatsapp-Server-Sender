<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supportlog extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'comment',
        'is_admin',
        'seen',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
