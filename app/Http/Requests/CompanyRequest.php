<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        'iin'=>'required|min:11|unique:companies',
        'kpp'=> 'required|min:9',
        'ogrn'=> 'required',
        'phone'=> 'required|min:10',
        'email'=> 'required|email|unique:companies',
        'short_name'=> 'required',
        'full_name'=> 'required',
        'link'=> 'required',
        'company_reg_date'=> 'required',
        'edo_provider'=> 'required',
        'edo_id'=> 'required',
        'user_id' => 'required:users',
        'tax_id' => 'required:taxes',
        'country_id' => 'required:countries',
        'address_id' => 'required:addresses',
        'post_address_id' => 'required:addresses',
      ];
    }

    public function messages()
    {
        return [
            'iin.required' => 'Inn is required!',
            'iin.unique'   => 'Inn is unique!',
            'kpp.unique'   => 'kpp is unique!',
            'phone.required' => 'phone is required!',
            'email.required' => 'email is required!',
            'short_name.unique'   => 'short_name is unique!',
            'full_name.required' => 'full_name is required!',
            'link.required' => 'link is required!',
            'company_reg_date.required' => 'company_reg_date is required!',
            'edo_provider.required' => 'edo_provider is required!',
            'edo_id.required' => 'edo_id is required!',
            'user_id.required' => 'user_id is required!',
            'tax_id.required' => 'tax_id is required!',
            'country_id.required' => 'country_id is required!',
            'address_id.required' => 'address_id is required!',
            'post_address_id.required' => 'post_address_id is required!',
        ];
    }
}
