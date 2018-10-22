<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserShallow as UserShallowResource;
use App\Http\Resources\TeamShallow as TeamShallowResource;
use App\Http\Resources\Location as LocationResource;

class Shift extends JsonResource
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
            'id'          => (string)$this->id,

            'user_id'     => (string)$this->user_id,
            'user'        => new UserShallowResource($this->user),

            'name'        => (string)$this->name,
            'description' => (string)$this->description,

            'location_id' => (string)$this->location_id,
            'location'    => new LocationResource($this->location),

            'min'         => (int)$this->min,
            'max'         => $this->max ? (int)$this->max : null,
            'desired'     => (int)$this->desired,

            'start_time'  => (string)$this->start_time,
            'end_time'    => (string)$this->end_time,

            'users'       => UserShallowResource::collection($this->users),
            'teams'       => TeamShallowResource::collection($this->teams),
        ];

        // $this->mergeAdditionalFields($request, $rtn, 'shifts');

        $rtn = array_merge($rtn, [
            'created_at'   => (string)$this->created_at,
            'updated_at'   => (string)$this->updated_at,
        ]);

        return $rtn;
    }
}
