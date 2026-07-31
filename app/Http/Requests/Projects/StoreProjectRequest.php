<?php

namespace App\Http\Requests\Projects;

use App\Config\CustomApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreProjectRequest extends CustomApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,completed,archived',
        ];
    }
}
