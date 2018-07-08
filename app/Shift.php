<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'leader_id',
        'location_id',
        'min',
        'max',
        'desired',
        'start_time',
        'end_time'
    ];

    public function teams() {
        return $this->belongsToMany('App\Team', 'team_shift');
    }

    public function users() {
        return $this->belongsToMany('App\User', 'user_shift');
    }

    public function location() {
        return $this->belongsTo('App\Location');
    }

    public function comments() {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function tags() {
        return $this->morphMany('App\Tag', 'tagable');
    }
}
