<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;

class UpdatebrandRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50|unique:brands,name,' . $this->brand->id,
            'reference' => 'required|string|max:150'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => Str::lower(__('Name')),
        ];
    }
}
