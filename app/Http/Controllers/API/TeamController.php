<?php

namespace App\Http\Controllers\API;

use App\Team;
use App\Http\Resources\Team as TeamResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('team.index', Team::class);

        if ($request->user()->can('team.index', Team::class)) {
            return TeamResource::collection(Team::all());
        }

        return TeamResource::collection(Team::where('user_id', Auth::user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeam $request)
    {
        $team = Team::create($request->all());

        if (Auth::user()->can('team.store.restricted', $team)) {
            $team->restricted = $request->input('restricted', false);
        }

        $team->save();

        return new TeamResource($team);
    }

    /**
     * Display the specified resource.
     *
     * @param  Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        $this->authorize('team.show', $team);

        return new TeamResource($team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeam $request, Team $team)
    {
        $team->fill(array_merge(
            $request->all(),
            $team->toArray()
        ));

        if (Auth::user()->can('team.update.restricted', $team)) {
            $team->restricted = $request->input('restricted', $team->restricted);
        }

        $team->save();

        return response(204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $this->authorize('team.destroy');

        $team->delete();

        return response(204);
    }
}
