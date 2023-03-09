<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "todo_id" => "required|numeric|exists:todos,id",
        ];
    }

    public function messages()
    {
        return [
            "todo_id.numeric" => "Your selected todo is not valid",
            "todo_id.exists" => "Your selected todo is not exist"
        ];
    }
}
