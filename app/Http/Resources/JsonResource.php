<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as BaseResource;
use Illuminate\Http\Request;

class JsonResource extends BaseResource
{
    protected function mergeAdditionalFields(Request &$request, array &$rtn, string $policy_prefix) {
        $rtn['additional_fields'] = [];
        $this->additional_fields->each(function($value, $key) use (&$rtn, &$request, &$policy_prefix) {
            $definition = $this->additional_field_list->firstWhere('key', $key);

            if ($definition && $request->user()->can("{$policy_prefix}.show" . ($definition->permissions_slug ? ".{$definition->permissions_slug}" : ''), $this->resource)) {
                $rtn['additional_fields'][$key] = $value;
            }
        });
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
