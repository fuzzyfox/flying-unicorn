<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoNotDisturb extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('donotdisturb.update', $this->route('donotdisturb'));
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
            'reason' => 'nullable|string',
            'start_time' => "{$required}|date",
            'end_time' => "required_with:start_time|date|after:start_time",
        ];
    }
}
