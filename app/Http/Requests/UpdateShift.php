<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShift extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('shifts.update', $this->route('shift'));
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
            'user_id' => "nullable|exists:users,id",
            'location_id' => 'nullable|exists:locations,id',
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'min' => 'nullable|integer|min:1',
            'max' => 'nullable|integer|gt:min',
            'desired' => 'nullable|integer|gte:min|lte:max',
            'start_time' => "{$required}|date",
            'end_time' => "required_with:start_time|date|after:start_time",
        ];
    }
}
