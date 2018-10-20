<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    public $fillable = ['name', 'description'];

    public function permissions() {
        return $this->morphMany('App\Permission', 'entity');
    }

    public function users() {
        return $this->belongsToMany('App\User', 'user_role');
    }
}
