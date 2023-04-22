<?php

namespace Common\Auth\Infrastructure\Http\Requests;

use Common\Auth\Sdk\Contract\RegisterContract;
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

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'The email has already been taken.',
            'username.unique' => 'The username has already been taken.',
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

    public function getEmail(): string
    {
        /** @var string $email */
        $email = $this->get('email');
        return $email;
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
