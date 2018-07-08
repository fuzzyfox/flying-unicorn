<?php

namespace App;

use Illuminate\Database\Eloquent\Pivot;

class UserShift extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'confirmed',
        'approved',
        'approved_by',
        'checkin',
        'checkin_by'
    ];

    public function comments() {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
