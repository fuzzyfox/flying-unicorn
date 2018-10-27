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

            'users'       => $this->users->map(function($user) {
                $rtn = [
                    'id'         => (string)$user->id,
                    'name'       => (string)$user->name,
                    'username'   => (string)$user->username,
                    'is_super'   => (bool)$user->is_super,
                ];

                if ($request->user()->is_super) {
                    if ($user->pivot->checkin) {
                        $rtn['checkin'] = $user->pivot->checkin ?? false;
                        $rtn['checkin_by'] = $user->checkin_by ?? null;
                    }

                    if ($user->pivot->verified) {
                        $rtn['verified'] = $user->pivot->verified ?? false;
                        $rtn['verified_by'] = $user->verified_by ?? null;
                    }

                    $rtn['hours'] = (float)$user->shifts->reduce(function($carry, $item) {
                        $date1 = new \DateTime($item->start_time);
                        $date2 = new \DateTime($item->end_time);

                        $diff = $date2->diff($date1);

                        $hours = $diff->h;
                        $hours = $hours + ($diff->days*24);
                        return $carry + $hours;
                    }, 0);

                    $rtn['claimed'] = (bool)$user->password;

                    $rtn['claim_code'] = (string)$user->claim_code;
                }

                // $user->mergeAdditionalFields($request, $rtn, 'users');

                $rtn = array_merge($rtn, [
                    'created_at' => (string)$user->created_at,
                    'updated_at' => (string)$user->updated_at,
                ]);

                return $rtn;
            }),
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
