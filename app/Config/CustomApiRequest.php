<?php

namespace App\Config;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CustomApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Setup custom validation for request error.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            apiResponse(
                $validator->errors(),
                'In-valid Inputs',
                422
            )
        );
    }
}
