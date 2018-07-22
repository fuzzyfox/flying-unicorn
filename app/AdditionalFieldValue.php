<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class AdditionalFieldValue extends Model
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
        'additional_field_id', 'entity_id', 'value',
    ];

    public function definition() {
        return $this->belongsTo(AdditionalField::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'entity_id');
    }

    public function team() {
        return $this->belongsTo(Team::class, 'entity_id');
    }

    public function location() {
        return $this->belongsTo(Location::class, 'entity_id');
    }

    public function shift() {
        return $this->belongsTo(Shift::class, 'entity_id');
    }
}
