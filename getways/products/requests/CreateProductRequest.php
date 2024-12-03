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
            'description'  => 'sometimes|nullable|string',
            'category_id'  => 'required|integer|exists:product_categories,id',
            'discount'     => 'sometimes|nullable|numeric|gt:0',
            'main_price'   => 'required|numeric|gt:0',
            'image'        => 'required|image|mimes:jpg,jpeg,png',
            'sizes' => 'required|array|min:1',
            'sizes.*.id' => 'required|integer|exists:sizes,id',
            'sizes.*.price' => 'required|numeric|gt:0',
        ];
    }
    public function messages()
    {
        return [
        'name.required' => 'The name field is required.',
        'name.string' => 'The name must be a valid string.',

        'description.string' => 'The description must be a valid string.',

        'category_id.required' => 'The category ID is required.',
        'category_id.integer' => 'The category ID must be an integer.',
        'category_id.exists' => 'The selected category ID does not exist.',

        'image.required' => 'The image field is required.',
        'image.image' => 'The file must be an image.',
        'image.mimes' => 'The image must be a file of type: jpg, jpeg, png.',

        'discount.numeric' => 'The discount must be a valid number.',
        'discount.gt' => 'The discount must be greater than 0.',

        'main_price.required' => 'The main price is required.',
        'main_price.numeric' => 'The main price must be a valid number.',
        'main_price.gt' => 'The main price must be greater than 0.',

        'sizes.required' => 'At least one size price is required.',
        'sizes.array' => 'The sizes price must be an array.',
        'sizes.min' => 'You must provide at least one size price.',

        'sizes.*.id.required' => 'The ID field in sizes price is required.',
        'sizes.*.id.integer' => 'The ID in sizes price must be an integer.',

        'sizes.*.price.required' => 'The price field in sizes price is required.',
        'sizes.*.price.numeric' => 'The price in sizes price must be a valid number.',
        'sizes.*.price.gt' => 'The price in sizes price must be greater than 0.',
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
