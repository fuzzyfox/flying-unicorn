<?php

namespace App\Http\Resources;

use App\Http\Resources\UserShallow as UserShallowResource;

class TeamShallow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status = 'pending';

        if ($this->status->approved) {
            $status = 'approved';
        }
        if ($this->status->rejected) {
            $status = 'rejected';
        }

        $rtn = [
            'id'           => (string)$this->id,
            'name'         => (string)$this->name,
            'description'  => (string)$this->description,
            'restricted'   => (bool)$this->restricted,
            'user_id'      => (string)$this->user_id,
            'status'       => (string)$status,
        ];

        $this->mergeAdditionalFields($request, $rtn, 'teams');

        $rtn = array_merge($rtn, [
            'created_at'   => (string)$this->created_at,
            'updated_at'   => (string)$this->updated_at,
        ]);

        return $rtn;
    }
}
