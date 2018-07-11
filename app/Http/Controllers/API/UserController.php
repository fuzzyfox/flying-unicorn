<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\StoreUser as StoreUserRequest;
use App\Http\Requests\UpdateUser as UpdateUserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('users.index', User::class);

        if ($request->user()->can('users.index', User::class)) {
            return UserResource::collection(User::all());
        }

        return UserResource::collection(User::where('id', $request->user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());

        if ($request->user()->is_super) {
            $user->is_super = $request->input('is_super', false);
        } else {
            $user->is_super = false;
        }

        $user->save();

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $this->authorize('users.show', $user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->isMethod('PATCH')) {
            $user->fill(array_merge(
                $user->toArray(),
                $request->all()
            ));
        } else {
            $user->fill($request->all());
        }

        if ($request->user()->can('users.update.password', $user) && $request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->user()->is_super) {
            $user->is_super = $request->input('is_super', $request->isMethod('PATCH') ? $user->is_super : false);
        }

        $user->save();

        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('users.destroy', $user);

        $user->delete();

        return response('', 204);
    }
}
