<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;

class AdditionalField extends JsonResource
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
            'id'               => (string)$this->id,
            'key'              => (string)$this->key,
            'entity'           => (string)$this->entity,
            'validator'        => (string)$this->validator,
            'permissions_slug' => (string)$this->permissions_slug,
            'default'          => json_decode($this->default),
            'label'            => (string)$this->label,
            'description'      => (string)$this->description,

            'created_by'       => (string)$this->created_by,
            'creator'          => new UserResource($this->creator),
        ];

        $rtn = array_merge($rtn, [
            'created_at'   => (string)$this->created_at,
            'updated_at'   => (string)$this->updated_at,
        ]);

        return $rtn;
    }
}
