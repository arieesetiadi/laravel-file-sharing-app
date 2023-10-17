<?php

namespace App\Http\Requests\API\V1\User;

use App\Constants\GeneralStatus;
use App\Constants\UserRoleCode;
use App\Http\Requests\BaseFormRequest;
use App\Models\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => normalize_phone($this->phone),
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
            'password' => 'required',
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
            'phone' => normalize_phone($this->phone),
            'user_role_id' => UserRole::query()->where('code', UserRoleCode::CUSTOMER)->first()->id,
            'password' => Hash::make($this->password),
            'status' => GeneralStatus::ACTIVE,
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
