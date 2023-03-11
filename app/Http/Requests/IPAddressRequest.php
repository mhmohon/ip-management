<?php

namespace App\Http\Requests;

class IPAddressRequest extends BaseAPIFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (request()->isMethod('PUT') || request()->isMethod('PATCH')) {
            $ipAddress = $this->route('ip_address');
            return $ipAddress->user_id === auth()->user()->id;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            "label" => "required|min:3",
        ];
        if (request()->isMethod('POST')) {
            $rules = [
                "label" => "required|min:3",
                "ip_address" => "required|ip",
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            "ip_address.ip" => "Invalid input! Please enter a valid IP address."
        ];
    }
}
