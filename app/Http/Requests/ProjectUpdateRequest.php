<?php

namespace App\Http\Requests;

use App\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ProjectUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => ['max:255'],
            'image'       => ['nullable', 'image'],
            'description' => ['nullable', 'string'],
            'due_date'    => ['nullable', 'date'],
            'status'      => [new Enum(ProjectStatus::class)],
        ];
    }
}
