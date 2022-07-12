<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;

class UpdateproductRequest extends BaseRequest
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
        $ruleNumbers = 'required|numeric';
        return [
            'name' => 'required|max:200|min:3|unique:products,name,' . $this->product->id,
            'size_id' => $ruleNumbers,
            'observations' => 'required|max:250|min:3',
            'brand_id' =>  $ruleNumbers,
            'inventory_quantity' => $ruleNumbers,
            'boarding_date' => 'required|date'
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
