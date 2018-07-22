<?php

namespace App\Http\Controllers\API;

use App\Location;
use App\Http\Resources\Location as LocationResource;
use App\Http\Requests\StoreLocation as StoreLocationRequest;
use App\Http\Requests\UpdateLocation as UpdateLocationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('locations.index', Location::class);

        return LocationResource::collection(Location::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationRequest $request)
    {

        $location = Location::create($request->all());

        $location->save();

        return new LocationResource($location);
    }

    /**
     * Display the specified resource.
     *
     * @param  Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Location $location)
    {
        $this->authorize('locations.show', $location);

        return new LocationResource($location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        if ($request->isMethod('PATCH')) {
            $location->fill(array_merge(
                $location->toArray(),
                $request->all()
            ));
        } else {
            $location->fill($request->all());
        }

        $location->save();

        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $this->authorize('locations.destroy', $location);

        $location->delete();

        return response('', 204);
    }
}
