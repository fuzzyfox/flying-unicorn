<?php

namespace App\Policies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    protected $slug_prefix = '';

    public function before($user, $ability) {
        if ($user->is_super) {
            return true;
        }

        if ($user->hasPermission($ability)) {
            return true;
        }
    }

    public function __call($method, $params) {
        $user = $params[0];
        $model = isset($params[1]) ? $params[1] : null;

        if ($model && ($user->id === $model->user_id || (get_class($model) == 'App\User' && $user->id == $model->id))) {
            if (
                $user->permissions()
                    ->where('slug', 'own.' . $this->slug_prefix . $method)
                    ->orWhere('slug', 'like', 'own.' . $this->slug_prefix . $method . '.%')
                    ->first()
            ) {
                return true;
            }

            foreach($user->roles as $role) {
                if (
                    $role->permissions()
                        ->where('slug', 'own.' . $this->slug_prefix . $method)
                        ->orWhere('slug', 'like', 'own.' . $this->slug_prefix . $method . '.%')
                        ->first()
                ) {
                    return true;
                }
            }
        }

        if (
            $user->permissions()
                ->where('slug', $this->slug_prefix . $method)
                ->orWhere('slug', 'like', $this->slug_prefix . $method . '.%')
                ->first()
        ) {
            return true;
        }
        foreach($user->roles as $role) {
            if (
                $role->permissions()
                    ->where('slug', $this->slug_prefix . $method)
                    ->orWhere('slug', 'like', $this->slug_prefix . $method . '.%')
                    ->first()
            ) {
                return true;
            }
        }

        return false;
    }
}
