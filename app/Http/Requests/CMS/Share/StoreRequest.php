<?php

namespace App\Http\Requests\CMS\Share;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'nullable',
            'files' => 'required',
            'files.*' => 'required|file',
            'user_ids' => 'required',
            'user_ids.*' => 'required|exists:users,id',
        ];
    }

    /**
     * Get the validated share data.
     */
    public function validatedShare(): array
    {
        return [
            'sender_user_id' => Auth::id(),
            'title' => trim($this->title),
            'description' => trim($this->description),
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
