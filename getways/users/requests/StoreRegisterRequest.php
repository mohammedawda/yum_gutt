<?php

namespace getways\users\requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRegisterRequest extends CreateUserRequest
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
        $rules = Parent::rules();
        $rules['national_id_photo']      = "required|image";
        $rules['national_id_photo_type'] = "required|string|in:1,2";
        $rules['national_id']            = "required|string";
        return $rules;
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'  => false,
            'code'    => 403,
            'message' => implode(', ', $validator->errors()->all()),
        ], 403));
    }
}
