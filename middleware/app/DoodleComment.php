<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoodleComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'doodle_id',
        'user_id',
        'comment'
    ];

    public function doodle()
    {
        return $this->belongsTo('App\Doodle');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
