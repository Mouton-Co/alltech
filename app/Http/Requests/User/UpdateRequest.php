<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $errorBag = 'userUpdate--';

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $this->errorBag .= $this->get('user_id');
        return [
            'name'             => 'required',
            'role_id'          => 'required',
            'email'            => 'required|unique:users,email,' . $this->get('user_id'),
            'password'         => "nullable|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16}$/",
            'confirm_password' => 'nullable|same:password',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function messages(): array
    {
        return [
            'regex' => "Password must contain one digit, one lowercase, one uppercase,
                one special character, no spaces, and be between 8-16 characters.",
            'same' => "Passwords don't match",
        ];
    }
}
