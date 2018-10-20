<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('users.update', $this->route('user'));
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
            'name' => "{$required}|string",
            'username' => [
                $required,
                'string',
                Rule::unique('users')->ignore($this->route('user')->id),
            ],
            'password' => 'nullable|confirmed',
            'is_super' => 'nullable|boolean',
        ];
    }
}
