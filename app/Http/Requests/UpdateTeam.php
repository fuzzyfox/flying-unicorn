<?php

namespace App\Http\Requests;

use App\Team;
use Illuminate\Validation\Rule;

class UpdateTeam extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('teams.update', $this->route('team'));
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
                Rule::unique('teams')->ignore($this->route('team')->id),
                'max:70',
            ],
            'description' => 'nullable|string',
            'user_id'     => 'nullable|exists:users,id',
            'restricted'  => 'nullable|boolean',
        ];
    }
}
