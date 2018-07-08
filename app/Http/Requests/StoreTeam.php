<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeam extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('team.store', \App\Team::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|string|unique:teams,name|max:70',
            'description' => 'nullable|string',
            'user_id'     => 'nullable|exists:users,id',
            'restricted'  => 'nullable|boolean',
        ];
    }
}
