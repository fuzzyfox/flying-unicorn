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
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'restricted'  => $this->restricted,
            'user_id'     => $this->user_id,
            'user'        => new UserResource(\App\User::find($this->user_id)),
            'created_at'  => (string)$this->created_at,
            'updated_at'  => (string)$this->updated_at,
        ];
    }
}
