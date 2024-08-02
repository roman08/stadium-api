<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class CoachRequest extends FormRequest
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

            "name" => "required",
            "last_name" => "required",
            "second_surname" => "required",
            "birth_date" => "required",
            "phone" => "required",
            "profile_img" => "",
            "email" => "required",
            "password" => "required",
            "bank_id" => "",
            "bank_account" => "",
            "account_type_id" => "required",
            "observations" => ""

        ];
    }

    public function messages()

    {

        return [

            "name.required" => "name es required",
            "last_name.required" => "last_name es required",
            "second_surname.required" => "second_surname es required",
            "birth_date.required" => "birth_date es required",
            "phone.required" => "phone es required",
            "email.required" => "email es required",
            "password.required" => "password es required",
            "bank_id.required" => "bank_id es required",
            "bank_account.required" => "bank_account es required",
            "account_type_id.required" => "account_type_id es required",
            "observations.required" => "observations es required"

        ];
    }
    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([
            'status'    => 'error',
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()->first()
        ]));
    }
}
