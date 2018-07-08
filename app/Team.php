<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
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
        'name', 'description', 'user_id',
    ];

    /**
     * Get the team lead
     */
    public function leader() {
        return $this->belongsTo('App\User');
    }

    public function members() {
        return $this->belongsToMany('App\User', 'user_team');
    }

    public function shifts() {
        return $this->belongsToMany('App\Shfit', 'team_shift');
    }

    public function comments() {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function tags() {
        return $this->morphMany('App\Tag', 'tagable');
    }
}
