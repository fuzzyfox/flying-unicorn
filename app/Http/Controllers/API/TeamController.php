<?php

namespace App\Http\Controllers\API;

use App\Team;
use App\Http\Resources\Team as TeamResource;
use App\Http\Requests\StoreTeam as StoreTeamRequest;
use App\Http\Requests\UpdateTeam as UpdateTeamRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('teams.index', Team::class);

        if ($request->user()->can('teams.index', Team::class)) {
            return TeamResource::collection(Team::all());
        }

        return TeamResource::collection(Team::where('user_id', $request->user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {

        $team = Team::create($request->all());

        if ($request->user()->can('teams.store.restricted', $team)) {
            $team->restricted = $request->input('restricted', false);
        }

        if ($request->user()->can('teams.store.user_id', $team)) {
            $team->user_id = $request->input('user_id', $request->user()->id);
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
    public function show(Request $request, Team $team)
    {
        $this->authorize('teams.show', $team);

        return new TeamResource($team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        if ($request->isMethod('PATCH')) {
            $team->fill(array_merge(
                $team->toArray(),
                $request->all()
            ));
        } else {
            $team->fill($request->all());
        }

        if ($request->user()->can('teams.update.restricted', $team)) {
            $team->restricted = $request->input('restricted', $request->isMethod('PATCH') ? $team->restricted : false);
        }

        if ($request->user()->can('teams.store.user_id', $team)) {
            $team->user_id = $request->input('user_id', $request->isMethod('PATCH') ? $team->user_id : $request->user()->id);
        }

        $team->save();

        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $this->authorize('teams.destroy', $team);

        $team->delete();

        return response('', 204);
    }
}
