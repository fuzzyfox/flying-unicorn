<?php

namespace App;

use App\Traits\Uuids;
use App\Traits\AdditionalFields;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use Uuids, AdditionalFields;

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
        'name', 'description','location_id'
    ];

    public function shifts() {
        return $this->hasMany(Shift::class);
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags() {
        return $this->morphMany(Tag::class, 'tagable');
    }
}
