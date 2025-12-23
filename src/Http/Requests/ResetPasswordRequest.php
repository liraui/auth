<?php

namespace LiraUi\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRule;

class ResetPasswordRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var PasswordRule $passwordRule */
        $passwordRule = PasswordRule::defaults();

        return [
            'token' => [
                'required',
                'string',
                'min:1',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'exists:users,email',
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                $passwordRule->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),
            ],
        ];
    }
}
