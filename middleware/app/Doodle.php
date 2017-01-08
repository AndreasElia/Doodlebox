<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doodle extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\DoodleComment');
    }

    public function ratings()
    {
        return $this->hasMany('App\DoodleRating');
    }
}
