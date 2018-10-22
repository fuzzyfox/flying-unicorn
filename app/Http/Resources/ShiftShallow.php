<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShiftShallow extends JsonResource
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

            'name'        => (string)$this->name,
            'description' => (string)$this->description,

            'location_id' => (string)$this->location_id,

            'min'         => (int)$this->min,
            'max'         => $this->max ? (int)$this->max : null,
            'desired'     => (int)$this->desired,

            'start_time'  => (string)$this->start_time,
            'end_time'    => (string)$this->end_time,
        ];

        // $this->mergeAdditionalFields($request, $rtn, 'shifts');

        $rtn = array_merge($rtn, [
            'created_at'   => (string)$this->created_at,
            'updated_at'   => (string)$this->updated_at,
        ]);

        return $rtn;
    }
}
