<?php

namespace Common\Auth\Infrastructure\Http\Requests;

use Common\Auth\Sdk\Contract\RegisterContract;
use Common\ValueObject\Email;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest implements RegisterContract
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
        /** @var string $maxLength */
        $maxLength = config('auth.maxPasswordLength');

        /** @var string $regexRule */
        $regexRule = config('auth.password_regex.rule');
        return [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'language_id' => ['required', 'numeric', 'max:255', 'exists:languages,id'],
            'password' => ['required', 'string', 'min:8', 'max:' . $maxLength, 'confirmed', 'regex:' . $regexRule],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:' . $maxLength, 'regex:' . $regexRule],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than :max characters.',

            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than :max characters.',
            'email.unique' => 'The email has already been taken.',

            'username.required' => 'The username field is required.',
            'username.string' => 'The username must be a string.',
            'username.max' => 'The username may not be greater than :max characters.',
            'username.unique' => 'The username has already been taken.',

            'language_id.required' => 'The language field is required.',
            'language_id.numeric' => 'The language must be a numeric value.',
            'language_id.max' => 'The language may not be greater than :max.',
            'language_id.exists' => 'The selected language is invalid.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least :min characters.',
            'password.max' => 'The password may not be greater than :max characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',

            'password_confirmation.required' => 'The password confirmation field is required.',
            'password_confirmation.string' => 'The password confirmation must be a string.',
            'password_confirmation.min' => 'The password confirmation must be at least :min characters.',
            'password_confirmation.max' => 'The password confirmation may not be greater than :max characters.',
            'password_confirmation.regex' => 'The password confirmation must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];
    }

    public function getName(): string
    {
        /** @var string $name */
        $name = $this->get('name');
        return $name;
    }

    public function getUsername(): string
    {
        /** @var string $username */
        $username = $this->get('username');
        return $username;
    }

    public function getEmail(): Email
    {
        /** @var string $email */
        $email = $this->get('email');
        return new Email($email);
    }

    public function getPassword(): string
    {
        /** @var string $password */
        $password = $this->get('password');
        return $password;
    }

    public function getLanguageId(): int
    {
        /** @var int $languageId */
        $languageId = $this->get('language_id');
        return $languageId;
    }
}
