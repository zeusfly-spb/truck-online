<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankDetailRequest extends FormRequest
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
        'bik'=>'required|min:9|max:9',
        'bank_name'=> 'required|max:160',
        'account'=> 'required|min:20|max:20',
        'k_account'=> 'required|min:20|max:20',
      ];
    }
}
