<?php

namespace getways\products\requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateProductRequest extends FormRequest
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
            'name'         => 'required|string',
            'description'  => 'nullable|string',
            'category_id'  => 'required|exists:categories,id',
            'image'        => 'required|image|mimes:jpg,jpeg,png',
            'small_price'  => 'required|numeric',
            'medium_price' => 'required|numeric',
            'large_price'  => 'required|numeric',
            'discount'     => 'required|numeric',
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
