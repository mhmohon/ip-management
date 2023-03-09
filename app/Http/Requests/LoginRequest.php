<?php

namespace App\Http\Requests;

class LoginRequest extends BaseAPIFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required",
            "password" => "required"
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please insert the email',
            'password.required' => 'Please insert the password'
        ];
    }
}
