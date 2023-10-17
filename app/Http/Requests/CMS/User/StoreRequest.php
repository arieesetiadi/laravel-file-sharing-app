<?php

namespace App\Http\Requests\CMS\User;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class StoreRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|unique:users,phone',
            'user_role_id' => 'required|exists:user_roles,id',
            'password' => 'required',
            'status' => 'required|boolean',
        ];
    }

    /**
     * Final result of the form request.
     */
    public function credentials(): array
    {
        return [
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ? normalize_phone($this->phone) : null,
            'user_role_id' => $this->user_role_id,
            'password' => Hash::make($this->password),
            'status' => $this->status,
        ];
    }

    /**
     * Global form request attributes, with internationalization.
     */
    public function attributes(): array
    {
        return BaseFormRequest::getAttributes();
    }
}
