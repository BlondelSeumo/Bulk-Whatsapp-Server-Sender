<?php

namespace App\Models;
use App\Autoload\HasUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
class Device extends Model
{
    use HasFactory, HasUid;

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function smstransaction()
    {
        return $this->hasMany('App\Models\Smstransaction');
    }
}
