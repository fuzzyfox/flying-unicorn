<?php

namespace App;

use App\Traits\Uuids;
use App\Traits\AdditionalFields;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use Uuids, AdditionalFields;

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
        'location_id',
        'min',
        'max',
        'desired',
        'start_time',
        'end_time'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function teams() {
        return $this->belongsToMany(Team::class, 'team_shift');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_shift');
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags() {
        return $this->morphMany(Tag::class, 'tagable');
    }
}
