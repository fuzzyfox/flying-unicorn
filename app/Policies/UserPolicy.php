<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy extends BasePolicy
{
    protected $slug_prefix = 'user.';
}
