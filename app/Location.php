<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];

    public function shifts() {
        return $this->hasMany('App\Shift');
    }

    public function comments() {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function tags() {
        return $this->morphMany('App\Tag', 'tagable');
    }
}
