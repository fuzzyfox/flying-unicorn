<?php

namespace App\Http\Controllers\API;

use App\Shift;
use App\Http\Resources\Shift as ShiftResource;
use App\Http\Requests\StoreShift as StoreShiftRequest;
use App\Http\Requests\UpdateShift as UpdateShiftRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('shifts.index', Shift::class);

        if ($request->user()->can('shifts.index', User::class)) {
            return ShiftResource::collection(Shift::all());
        }

        return ShiftResource::collection(Shift::where('user_id', $request->user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShiftRequest $request)
    {
        $shift = Shift::create($request->all());

        if ($request->user()->can('shifts.transfer', Shift::class)) {
            $shift->user_id = $request->input('user_id', $request->user()->id);
        } else {
            $shift->user_id = $request->user()->id;
        }

        $shift->save();

        return new ShiftResource($shift);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shfit)
    {
        $this->authorize('shifts.show', $shift);

        return new ShiftResource($shift);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShiftRequest $request, Shift $shift)
    {
        $shift_user_id = $shift->user_id;
        if ($request->isMethod('PATCH')) {
            $shift->fill(array_merge(
                $shift->toArray(),
                $request->all()
            ));
        } else {
            $shift->fill($request->all());
        }

        if ($request->user()->can('shifts.transfer', $shift)) {
            $shift->user_id = $request->input('user_id', $request->user()->id);
        } else {
            $shift->user_id = $shift_user_id;
        }

        $shift->save();

        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shfit $shift)
    {
        $this->authorize('shifts.destroy', $shift);

        $shift->delete();

        return response('', 204);
    }
}
