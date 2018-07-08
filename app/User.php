<?php

namespace App;

use App\Traits\Uuids;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Uuids, HasApiTokens, Notifiable;

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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get teams the user leads
     */
    public function leads() {
        return $this->hasMany('App\Team');
    }

    /**
     * Get the users teams (inc, unapproved)
     */
    public function teams() {
        return $this->belongsToMany('App\Team', 'user_team')
            ->withPivot('approved')
            ->wherePivot('rejected', '=', null)
            ->as('status');
    }

    public function shifts() {
        return $this->belongsToMany('App\Shift', 'user_shift')
            ->withPivot('confirmed')
            ->where('approved', '<>', null)
            ->as('status');
    }

    public function roles() {
        return $this->belongsToMany('App\Role', 'user_role');
    }

    public function permissions() {
        return $this->morphMany('App\Permission', 'entity');
    }

    public function comments() {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function tags() {
        return $this->morphMany('App\Tag', 'tagable');
    }

    public function hasPermission(string $slug) {
        if ($this->is_super) {
            return true;
        }
        if ($this->permissions()->where('slug', $slug)->first()) {
            return true;
        }

        foreach($this->roles as $role) {
            if ($role->permissions()->where('slug', $slug)->first()) {
                return true;
            }
        }

        return false;
    }

    public function hasRole(string $search) {
        if ($this->is_super) {
            return true;
        }
        return !! $this->roles()
            ->where('id', $search)
            ->orWhere('name', $search)
            ->first();
    }
}
