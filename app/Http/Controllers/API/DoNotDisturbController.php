<?php

namespace App\Http\Controllers\API;

use App\DoNotDisturb;
use App\Http\Resources\DoNotDisturb as DoNotDisturbResource;
use App\Http\Requests\StoreDoNotDisturb as StoreDoNotDisturbRequest;
use App\Http\Requests\UpdateDoNotDisturb as UpdateDoNotDisturbRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoNotDisturbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('donotdisturb.index', DoNotDisturb::class);

        if ($request->user()->can('donotdisturb.index', User::class)) {
            return DoNotDisturbResource::collection(DoNotDisturb::all());
        }

        return DoNotDisturbResource::collection(DoNotDisturb::where('user_id', $request->user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDoNotDisturbRequest $request)
    {
        $donotdisturb = new DoNotDisturb($request->all());

        if ($request->user()->can('donotdisturb.transfer', DoNotDisturb::class)) {
            $donotdisturb->user_id = $request->input('user_id', $request->user()->id);
        } else {
            $donotdisturb->user_id = $request->user()->id;
        }

        if (
            DoNotDisturb::where([
                'user_id' => $donotdisturb->user_id,
                'start_time' => $donotdisturb->start_time,
                'end_time' => $donotdisturb->end_time,
            ])->first()
        ) {
            return abort(409, 'Conflict');
        }

        $donotdisturb->save();

        return new DoNotDisturbResource($donotdisturb);
    }

    /**
     * Display the specified resource.
     *
     *  @param DoNotDisturb  $donotdisturb
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DoNotDisturb $donotdisturb)
    {
        $this->authorize('donotdisturb.show', $donotdisturb);

        return new DoNotDisturbResource($donotdisturb);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDoNotDisturbRequest $request, DoNotDisturb $donotdisturb)
    {
        $donotdisturb_user_id = $donotdisturb->user_id;
        if ($request->isMethod('PATCH')) {
            $donotdisturb->fill(array_merge(
                $donotdisturb->toArray(),
                $request->all()
            ));
        } else {
            $donotdisturb->fill($request->all());
        }

        if ($request->user()->can('donotdisturb.transfer', $donotdisturb)) {
            $donotdisturb->user_id = $request->input('user_id', $request->user()->id);
        } else {
            $donotdisturb->user_id = $donotdisturb_user_id;
        }

        $donotdisturb->save();

        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DoNotDisturb $donotdisturb)
    {
        $this->authorize('donotdisturb.destroy', $donotdisturb);

        $donotdisturb->delete();

        return response('', 204);
    }
}
