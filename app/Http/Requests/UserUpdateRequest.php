<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route("user");

        return [
            "name"     => ["string", "max:255"],
            "email"    => ["email", Rule::unique('users')->ignore($user->id)],
            "password" => ['confirmed', Password::min(8)->letters()->symbols()],
        ];
    }
}
