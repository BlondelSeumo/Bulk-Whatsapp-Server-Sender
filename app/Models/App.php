<?php

namespace App\Models;
use App\Autoload\HasUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
class App extends Model
{
    use HasFactory, HasUid;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'key',
        'user_id',
        'title',
        'webiste',
    ];

    protected static function boot()
    {
        parent::boot();

        
        static::creating(function($model){
            $key=Str::random(32);
            $model->key = Str::uuid()->toString();
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function generateAppKey()
    {
       $key=\Str::random(32);
       $check=App::where('key',$key)->first();
       if ($check != null) {
           return $this->generateAppKey();
       }
       return $key;
    }

    public function liveMessages()
    {
        return $this->hasMany('App\Models\Smstransaction');
    }

    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
