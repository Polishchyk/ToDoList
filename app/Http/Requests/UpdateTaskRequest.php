<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'string',
            'project_id' => 'required|numeric|exists:projects,id',
            'priority' => 'numeric',
            'parent_id' => 'numeric|exists:tasks,id',
            'task_status_id' => 'required|numeric|exists:task_statuses,id',
        ];
    }
}
