<?php

namespace App\Http\Requests\Tasks;

use App\Config\CustomApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreTaskRequest extends CustomApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
            'due_date' => 'required|date|after_or_equal:today',
        ];
    }
}
