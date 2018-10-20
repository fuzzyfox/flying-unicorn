<?php

namespace App\Http\Resources;

class DoNotDisturb extends JsonResource
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
            'id' => (string)$this->id,
            'start_time' => (string)$this->start_time,
            'end_time' => (string)$this->end_time,
            'reason' => $this->reason ? (string)$this->reason : null,
            'user_id' => (string)$this->user_id
        ];

        $rtn = array_merge($rtn, [
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ]);

        return $rtn;
    }
}
