<?php

namespace getways\products\requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateExtraProductRequest extends FormRequest
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
            'category_name'          => 'required|string',
            'is_require'             => 'required|in:0,1',
            'extra_products'         => 'required|array|min:1',
            'extra_products.*.name'  => 'required|string',
            'extra_products.*.price' => 'required|numeric|gt:0',
            'extra_products.*.image' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }
    public function messages(): array
    {
        return [
        'category_name.required' => 'The name field is required.',
        'category_name.string' => 'The name must be a valid string.',

        'extra_products.required' => 'At least one size price is required.',
        'extra_products.array' => 'The extra products price must be an array.',
        'extra_products.min' => 'You must provide at least one size price.',

        'extra_products.*.image.required' => 'The image field is required.',
        'extra_products.*.image.image' => 'The file must be an image.',
        'extra_products.*.image.mimes' => 'The image must be a file of type: jpg, jpeg, png.',

        'extra_products.*.name.required' => 'The ID field in extra products price is required.',
        'extra_products.*.name.string' => 'The name in extra product must be a valid string.',

        'extra_products.*.price.required' => 'The price field in extra products price is required.',
        'extra_products.*.price.numeric' => 'The price in extra products price must be a valid number.',
        'extra_products.*.price.gt' => 'The price in extra products price must be greater than 0.',
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
