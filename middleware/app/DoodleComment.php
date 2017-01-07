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
        'message'
    ];

    protected $hidden = [
        'doodle_id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at'
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
