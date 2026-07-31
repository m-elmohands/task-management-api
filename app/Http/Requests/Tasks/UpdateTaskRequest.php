<?php

namespace App\Http\Requests\Tasks;

use App\Config\CustomApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateTaskRequest extends CustomApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|required|in:low,medium,high',
            'status' => 'sometimes|required|in:todo,in_progress,done',
            'due_date' => 'sometimes|required|date',
        ];
    }
}
