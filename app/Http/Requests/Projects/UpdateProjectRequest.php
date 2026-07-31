<?php

namespace App\Http\Requests\Projects;

use App\Config\CustomApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateProjectRequest extends CustomApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:active,completed,archived',
        ];
    }
}
