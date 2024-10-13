<?php

namespace getways\users\requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChargeWalletRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'amount' => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'user_phone' => 'nullable|required_unless:payment_method_id,1,8,9,10|string',
            'reference_number' => 'nullable|string',
            'transfer_photo' => 'nullable|required_unless:payment_method_id,1,8,9,10|image',
        ];
    }


    public function messages()
    {
        return [
            'user_phone.required_if' => __('validation.custom.user_phone.required_if'),
            'reference_number.required_if' => __('validation.custom.reference_number.required_if'),
            'transfer_photo.required_if' => __('validation.custom.transfer_photo.required_if'),
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
