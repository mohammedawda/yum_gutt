<?php

namespace getways\users\requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            "first_name"            => 'required|max:200',
            "last_name"             => 'sometimes|nullable|max:200',
            "phone"                 => 'required|string',
            "email"                 => 'required|email|'.Rule::unique('users')->ignore(Auth::id()),
            "city_id"               => 'required|exists:cities,id',
            "country_id"            => 'required|exists:countries,id',
            "country_code"          => 'required|string',
            "nationalId_photo"      => 'sometimes|nullable',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'code' => 403,
            'message' => implode(', ', $validator->errors()->all()),
        ], 403));
    }
}
