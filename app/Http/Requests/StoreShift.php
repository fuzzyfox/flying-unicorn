<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShift extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('shifts.store', \App\Shift::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'location_id' => 'nullable|exists:locations,id',
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'min' => 'nullable|integer|min:1',
            'max' => 'nullable|integer|gt:min',
            'desired' => 'nullable|integer|gte:min|lte:max',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time'
        ];
    }
}
