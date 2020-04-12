<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationWithProfileRequest extends FormRequest
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
            'type_id' => 'required|numeric|exists:organization_types,id',
            'parent_id' => 'numeric|exists:organizations,id',
            'created_by' => 'required|exists:users,id',
            'status' => 'numeric',
            'organization_id' => 'numeric',
            'staff' => 'required|string',
            'email' => 'required|email',
            'phone' => 'numeric',
            'gsm_phone' => 'required|numeric',
            'fax' => 'numeric',
            'address' => 'required|string',
            'tax_administration' => 'string',
            'tax_no' => 'numeric',
            'logo' => 'string',
        ];
    }
}
