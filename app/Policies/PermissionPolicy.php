<?php

namespace App\Policies;

use App\User;
use App\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy extends BasePolicy
{
    protected $slug_prefix = 'permission.';
}
