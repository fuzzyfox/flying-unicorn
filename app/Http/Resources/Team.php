<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Team extends JsonResource
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
            'id'           => (string)$this->id,
            'name'         => (string)$this->name,
            'description'  => (string)$this->description,
            'restricted'   => (bool)$this->restricted,
            'user_id'      => (string)$this->user_id,
            'user'         => new UserResource($this->user),
            'members'      => UserResource::collection($this->members),
        ];

        if ($request->user()->can('teams.show.applications', $this->resource)) {
            $rtn['applications'] = UserResource::collection($this->applications);
        }

        $rtn = array_merge($rtn, [
            'created_at'   => (string)$this->created_at,
            'updated_at'   => (string)$this->updated_at,
        ]);

        return $rtn;
    }
}
