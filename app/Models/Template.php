<?php

namespace App\Models;
use App\Autoload\HasUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
class Template extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'title',
        'body',
        'type',
        'status',
    ];

    protected $casts=[
        'body'=>'json'
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
