<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Requests\BaseFormRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class LoginRequest extends FormRequest
{
    /**
     * Default service class.
     */
    protected UserService $userService;

    /**
     * Initiate controller properties value.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ];
    }

    /**
     * Validate user data after main rules.
     */
    public function withValidator(Validator $validator): void
    {
        if ($validator->safe()->all()) {
            $validator->after(function ($validator) {
                // Get user data
                $user = $this->userService->findByUsername($this->username);

                // Cek user status
                if (!$user->status) {
                    $validator->errors()->add('account', 'Account is inactive.');
                }

                // Verify user password
                if (!Hash::check($this->password, $user->password)) {
                    $validator->errors()->add('credentials', 'Invalid credential or password. Please try again.');
                }
            });
        }
    }

    /**
     * Validated user data.
     */
    public function validatedUser(): User
    {
        return $this->userService->findByUsername($this->username);
    }

    /**
     * Global form request attributes, with internationalization.
     */
    public function attributes(): array
    {
        return BaseFormRequest::getAttributes();
    }
}
