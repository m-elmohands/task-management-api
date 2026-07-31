<?php

namespace App\Http\Requests\Auth;

use App\Config\CustomApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class LoginRequest extends CustomApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }
}
