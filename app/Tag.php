<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
