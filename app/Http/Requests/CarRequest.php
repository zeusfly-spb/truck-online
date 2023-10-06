<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
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
        //'icon'=>'required',
        //'number'=> 'required',
        //'mark_model'=> 'required',
        //'max_weigth'=> 'required',
        //'country_id'=> 'required',
        //'car_type_id'=> 'required',
        //'right_use_id'=> 'required',
        //'sts'=>'required',
        //'sts_file_1'=> 'required',
        //'sts_file_2'=> 'required',
      ];
    }
}
