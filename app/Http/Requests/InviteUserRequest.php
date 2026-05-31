<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class InviteUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('invite', [User::class, $this->role, $this->company_id]);
    }

    public function rules(): array
    {
        $validRoles = $this->user()->hasRole('SuperAdmin')
            ? 'Admin,Member'
            : 'Admin,Member';

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:' . $validRoles],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }
}
