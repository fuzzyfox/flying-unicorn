<?php

namespace App\Http\Resources;


class UserShallow extends JsonResource
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

        $this->mergeAdditionalFields($request, $rtn, 'users');

        $rtn = array_merge($rtn, [
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ]);

        return $rtn;
    }
}
