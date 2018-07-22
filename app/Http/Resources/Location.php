<?php

namespace App\Http\Resources;

class Location extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rtn = [];

        $this->mergeAdditionalFields($request, $rtn, 'locations');

        $rtn = array_merge($rtn, [
            'created_at'   => (string)$this->created_at,
            'updated_at'   => (string)$this->updated_at,
        ]);
    }
}
