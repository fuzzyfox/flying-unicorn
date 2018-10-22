<?php

namespace App\Http\Resources;


use App\Http\Resources\TeamShallow as TeamShallowResource;
use App\Http\Resources\DoNotDisturb as DoNotDisturbResource;
use App\Http\Resources\ShiftShallow as ShiftShallowResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rtn = [
            'id'         => (string)$this->id,
            'name'       => (string)$this->name,
            'username'   => (string)$this->username,
            'is_super'   => (bool)$this->is_super,
        ];

        if ($request->user()->can('users.show.teams.status', $this->resource)) {
            $rtn['teams'] = TeamShallowResource::collection($this->teams);
        }

        if ($request->user()->can('users.show.donotdisturbs', $this->resource)) {
            $rtn['dnds'] = DoNotDisturbResource::collection($this->donotdisturbs);
        }

        if ($request->user()->can('users.show.shifts', $this->resource)) {
            $rtn['shifts'] = ShiftShallowResource::collection($this->donotdisturbs);
        }

        $this->mergeAdditionalFields($request, $rtn, 'users');

        $rtn = array_merge($rtn, [
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ]);

        return $rtn;
    }
}
