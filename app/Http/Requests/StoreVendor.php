<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendor extends FormRequest
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
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|string',
            'comp_code'     => 'required|not_in:0',
            'tax_number'    => 'nullable|string',
            'phone'         => 'nullable|string',
            'website'       => 'nullable|string',
            'acc_no'        => 'nullable|numeric',
            'acc_name'      => 'nullable|string',
            'acc_ifsc'      => 'nullable|string', 
            'enabled'       => 'required',
            'address'       => 'nullable|string',
            'note'          => 'nullable|string',
           

        ];
    }
}
