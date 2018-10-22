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
        $rtn = [
            'id'           => (string)$this->id,
            'name'         => (string)$this->name,
            'description'  => (string)$this->description,
        ];

        // $this->mergeAdditionalFields($request, $rtn, 'locations');

        return $rtn;
    }
}
