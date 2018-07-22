<?php

namespace App\Http\Requests;

use App\Location;
use Illuminate\Validation\Rule;

class UpdateLocation extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('locations.update', $this->route('location'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $required = $this->method() === 'PATCH' ? 'nullable' : 'required';
        return [
            'name' => [
                $required,
                'string',
                Rule::unique('locations')->ignore($this->route('location')->id),
                'max:70',
            ],
            'description' => 'nullable|string'
        ];
    }
}
