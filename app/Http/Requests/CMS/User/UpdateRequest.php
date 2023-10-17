<?php

namespace App\Http\Requests\CMS\User;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('cms')->check();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => $this->phone ? normalize_phone($this->phone) : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(Request $request): array
    {
        return [
            'username' => 'required|unique:users,username,' . $request->user,
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $request->user,
            'phone' => 'nullable|unique:users,phone,' . $request->user,
            'user_role_id' => 'required|exists:user_roles,id',
            'status' => 'required|boolean',
        ];
    }

    /**
     * Final result of the form request.
     */
    public function credentials(): array
    {
        $credentials = [
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ? normalize_phone($this->phone) : null,
            'user_role_id' => $this->user_role_id,
            'status' => $this->status,
        ];

        // Include new password if its edited
        if ($this->password) {
            $credentials['password'] = Hash::make($this->password);
        }

        return $credentials;
    }

    /**
     * Global form request attributes, with internationalization.
     */
    public function attributes(): array
    {
        return BaseFormRequest::getAttributes();
    }
}
