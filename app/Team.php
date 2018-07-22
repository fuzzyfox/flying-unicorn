<?php

namespace App;

use App\Traits\Uuids;
use App\Traits\AdditionalFields;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
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
        'name', 'description',
    ];

    /**
     * Get the team lead
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function members() {
        return $this->belongsToMany(User::class, 'user_team')
            ->as('status')
            ->wherePivot('approved', '<>', null)
            ->withTimestamps();
    }

    public function applications() {
        return $this->belongsToMany(User::class, 'user_team', 'user_id', 'team_id')
            ->wherePivot('rejected', '<>', null)
            ->wherePivot('approved', '=', null)
            ->as('status')
            ->withTimestamps();
    }

    public function shifts() {
        return $this->belongsToMany(Shfit::class, 'team_shift');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags() {
        return $this->morphMany(Tag::class, 'tagable');
    }
}
