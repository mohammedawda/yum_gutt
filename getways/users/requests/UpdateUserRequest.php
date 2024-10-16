<?php

namespace getways\users\requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name'                  => 'nullable|string',
            'country_id'            => ['nullable', Rule::exists('countries', 'id')->where('countries.deleted_at', null)],
            'city_id'               => ['nullable', Rule::exists('cities', 'id')->where('cities.deleted_at', null)],
            'national_id_photo'     => 'nullable|image|mimes:png,jpg,jpeg',
            'national_id_photo_type'=> 'nullable|string|in:passport,national_id',
            'national_id'           => 'nullable|string',
            'email'                 => 'nullable|email|unique:users',
            'phone'                 => 'nullable|unique:users',
            'fcm'                   => 'nullable',
            'country_code'          => 'nullable|string|required_with:phone',
            'role_id'               => 'nullable|in:1,2,3',
            'status'                => 'nullable|boolean',
            'block'                 => 'nullable|boolean'
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
