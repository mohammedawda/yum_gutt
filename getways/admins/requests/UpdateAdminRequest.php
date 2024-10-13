<?php

namespace getways\admins\requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends CreateAdminRequest
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
        $rules['email'] = 'required|email|' . Rule::unique('admins')->ignore(request()->route('id'));
        $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        return $rules;
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
