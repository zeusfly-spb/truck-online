<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
      return [
        'user_id'=>'required:users',
        'container_id'=> 'required:containers',
        // 'company_id'=> 'required:companies',

        'from_address_id'=> 'required:addresses',
        'from_date'=> 'required',
        'from_slot'=> 'required',
        'from_contact_name'=> 'required',
        'from_contact_phone'=> 'required',
        'from_contact_email'=> 'required',

        'delivery_adress_id'=>'required:addresses',
        'delivery_date'=> 'required',
        'delivery_slot'=> 'required',
        'delivery_contact_name'=> 'required',
        'delivery_contact_phone'=> 'required',
        'delivery_contact_email'=> 'required',

        'return_address_id'=>'required:addresses',
        'return_date'=> 'required',
        'return_slot'=> 'required',
        'return_contact_name'=> 'required',
        'return_contact_phone'=> 'required',
        'return_contact_email'=> 'required',


        'price'=> 'required',
        'weight'=> 'required',
        'length_algo'=> 'required',
        'length_real'=>'required',

      ];
    }
}
