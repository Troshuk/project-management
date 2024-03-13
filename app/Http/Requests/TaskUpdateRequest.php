<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"             => ['max:255'],
            'image'            => ['nullable', 'image'],
            "description"      => ['nullable', 'string'],
            'due_date'         => ['nullable', 'date'],
            'project_id'       => [Rule::exists(Project::class, 'id')],
            'assigned_user_id' => [Rule::exists(User::class, 'id')],
            'status'           => [new Enum(TaskStatus::class)],
            'priority'         => [new Enum(TaskPriority::class)],
        ];
    }
}
