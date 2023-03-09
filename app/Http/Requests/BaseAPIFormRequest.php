<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseAPIFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * @param Validator $validator
     * @return JsonResponse
     */
    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'code'      => Response::HTTP_UNPROCESSABLE_ENTITY,
            'success'   => false,
            'message'   => 'Validation erros',
            'errors'    => $validator->errors(),
            'timestamp' => now()
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
