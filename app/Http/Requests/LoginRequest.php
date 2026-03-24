<?php

namespace App\Http\Requests;

use App\Models\V1\System\Users\UsersAccountModel;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
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
                    if (!$model_user) {
                        return $fail(ucfirst($attribute) . " not found.");
                    }
                },
            ],
            'password' => [
                'required',
                function ($attribute, $value, $fail) {
                    $email = request()->email;

                    $model_user = UsersAccountModel::where('email', $email)
                        ->first();

                    if ($model_user) {
                        if (!Hash::check($value, $model_user->password)) {
                            return $fail(ucfirst($attribute) . " invalid password.");
                        }
                    }
                },
            ],
        ];
    }
}
