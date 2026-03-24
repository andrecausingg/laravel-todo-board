<?php

namespace App\Http\Requests\V1\System\Todo;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
        $method = request()->method();

        $rules = [
            'title' => 'required|string|max:255',
            'status' => 'required|string|in:todo,in_progress,done',
            'description' => 'nullable|string',
        ];

        return array_map(
            fn($rule) => $method === 'PATCH'
                ? str_replace('required', 'sometimes', $rule)
                : ($method === 'DELETE'
                    ? str_replace('required', 'nullable', $rule)
                    : $rule
                ),
            $rules
        );
    }

    public function messages(): array
    {
        return [
            'status.in' => 'The status must be either todo, in_progress, or done.',
            'expired_at.after_or_equal' => 'The expiration date cannot be in the past.',
        ];
    }
}
