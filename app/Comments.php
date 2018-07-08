<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function commentable() {
        return $this->morphTo();
    }

    public function comments() {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function tags() {
        return $this->morphMany('App\Tag', 'tagable');
    }
}
