<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Assuming only authenticated users can update users
        // return auth()->check();

        // Get the current authenticated user
        $user = auth()->user();

        // Check if the user is admin or superadmin
        return $user && ($user->hasRoles('admin') || $user->hasRoles('superadmin'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user ? $this->user->id : null;

        return [
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'password' => $this->isMethod('post') ? 'required|string|min:6' : 'sometimes|nullable|string|min:6',
        ];
    }
}
