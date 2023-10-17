<?php

namespace App\Http\Requests\API\V1\User;

use App\Constants\GeneralStatus;
use App\Constants\UserRoleCode;
use App\Http\Requests\BaseFormRequest;
use App\Models\UserRole;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UpdateRequest extends FormRequest
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
        // Check user existance
        $user = (new UserService())->find($this->user);

        if (! $user) {
            throw new ModelNotFoundException('User data is not found.', Response::HTTP_NOT_FOUND);
        }

        // Refactor phone number to i18n format
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
            'username' => 'required|unique:users,username,'.$this->user,
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->user,
            'phone' => 'nullable|unique:users,phone,'.$this->user,
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
            'phone' => normalize_phone($this->phone),
            'user_role_id' => UserRole::query()->where('code', UserRoleCode::CUSTOMER)->first()->id,
            'status' => GeneralStatus::ACTIVE,
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
