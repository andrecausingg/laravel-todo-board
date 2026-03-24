<?php

namespace App\Http\Requests\V1\System\Users;

use App\Models\V1\System\Users\UsersAccountModel;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email:rfc,dns',
                function ($attribute, $value, $fail) {
                    $model_user = UsersAccountModel::where('email', $value)
                        ->exists();
                    if ($model_user) {
                        return $fail(ucfirst($attribute) . " is already in exist.");
                    }
                },
            ],
            'password' => 'required|min:8|confirmed'
        ];
    }
}
