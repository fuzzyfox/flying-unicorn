<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
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
        return $this->morphMany(static::class, 'commentable');
    }

    public function tags() {
        return $this->morphMany(Tag::class, 'tagable');
    }
}
