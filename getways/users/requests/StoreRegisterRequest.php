<?php

namespace getways\users\requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class StoreRegisterRequest extends FormRequest
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
            'country_id'            => ['required', Rule::exists('countries', 'id')->where('countries.deleted_at', null)],
            'city_id'               => ['required', Rule::exists('cities', 'id')->where('cities.deleted_at', null)],
            'national_id_photo'     => 'required|image|mimes:png,jpg,jpeg',
            'national_id_photo_type'=> 'required|string|in:1,2',
            'national_id'           => 'required|string',
            'location'              => 'required|string',
            'profile_photo'         => 'nullable|image|mimes:png,jpg,jpeg',
            'email'                 => 'required|email|unique:users',
            'phone'                 => 'required|unique:users',
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'fcm'                   => 'nullable',
            'country_code'          => 'required|string',
            'status'                => 'nullable|boolean',
            'block'                 => 'nullable|boolean',
            'terms_and_condition'   => "required|in:0,1",
        ];
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
