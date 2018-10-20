<?php

namespace App\Http\Resources;


use App\Http\Resources\UserTeam as UserTeamResource;
use App\Http\Resources\DoNotDisturb as DoNotDisturbResource;

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
            'is_super'   => (bool)$this->is_super,
        ];

        if ($request->user()->can('users.show.email', $this->resource)) {
            $rtn['email'] = (string)$this->email;
        }

        if ($request->user()->can('users.show.teams.status', $this->resource)) {
            $rtn['teams'] = UserTeamResource::collection($this->teams);
        }

        if ($request->user()->can('users.show.donotdisturbs', $this->resource)) {
            $rtn['dnds'] = DoNotDisturbResource::collection($this->donotdisturbs);
        }


        $this->mergeAdditionalFields($request, $rtn, 'users');

        $rtn = array_merge($rtn, [
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ]);

        return $rtn;
    }
}
