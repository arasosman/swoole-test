<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:100',
            'description' => 'string',
            'type_id' => 'required|numeric|exists:group_types,id',
            'organization_id' => 'required|numeric|exists:organizations,id',
            'created_by' => 'required|numeric|exists:users,id'
        ];
    }
}
