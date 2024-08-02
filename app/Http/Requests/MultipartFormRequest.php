<?php

namespace App\Http\Requests;


use App\Enums\PromissoryNoteReasonType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class MultipartFormRequest extends FormRequest
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
   * Prepare the data for validation.
   *
   * @return void
   *             
   * @throws \JsonException
   */
    protected function prepareForValidation(): void
    {
        $this->merge(json_decode($this->payload, true, 512, JSON_THROW_ON_ERROR));
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'           => ['bail', 'required', 'numeric'],
            'uploaded_file'     => ['bail', 'required', 'file', 'mimes:xls,xlsx'],
            'tipo_fuente'       => ['bail', 'required', 'numeric'],
        ];
    }


    public function messages()
    {

        return [

            'user_id.required' => 'El id del usuario es requerido',
            'uploaded_file.required' => 'El archivo es requerido',
            'uploaded_file.mimes' => 'El archivo solo puede ser de tipo xls,xlsx',
           

        ];

    }
    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([
            'status'    => 'error',
            'msg'       => $validator->errors()->first()
        ]));

    }


}
