<?php

namespace App\Policies;

use App\User;
use App\Shift;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShiftPolicy extends BasePolicy
{
    protected $slug_prefix = 'shifts.';
}
