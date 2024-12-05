<?php

namespace getways\products\requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateExtraProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|string',
            'price' => 'required|numeric|gt:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }

   protected function failedValidation(Validator $validator)
   {
       throw new HttpResponseException(response()->json([
           'status'  => false,
           'message' => implode(', ', $validator->errors()->all()),
       ], 403));
   }
}
