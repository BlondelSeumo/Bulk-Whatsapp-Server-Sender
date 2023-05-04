<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ticket_no',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Support::max('id') + 1;
            $model->ticket_no = str_pad($model->id, 7, '0', STR_PAD_LEFT);
        });
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function conversations()
    {
       return $this->hasMany('App\Models\Supportlog');
    }
}
