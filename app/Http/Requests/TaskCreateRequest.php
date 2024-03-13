<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TaskCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"             => ['required', 'max:255'],
            'image'            => ['nullable', 'image'],
            "description"      => ['nullable', 'string'],
            'due_date'         => ['nullable', 'date'],
            'project_id'       => ['required', Rule::exists(Project::class, 'id')],
            'assigned_user_id' => ['required', Rule::exists(User::class, 'id')],
            'status'           => ['required', new Enum(TaskStatus::class)],
            'priority'         => ['required', new Enum(TaskPriority::class)],
        ];
    }
}
