<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class AdditionalField extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function values() {
        return $this->hasMany(AdditionalFieldValue::class);
    }

    public function creator() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
