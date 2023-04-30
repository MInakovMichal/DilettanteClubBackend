<?php

namespace Common\Auth\Infrastructure\Http\Requests;

use Common\Auth\Sdk\Contract\LoginContract;
use Common\ValueObject\Email;
use Common\ValueObject\RoleValueObject;
use Illuminate\Foundation\Http\FormRequest;
use InvalidArgumentException;

class LoginRequest extends FormRequest implements LoginContract
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
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:' . $maxLength, 'regex:' . $regexRule],
            'device_token' => ['required', 'string'],
        ];
    }

    public function getDeviceToken(): string
    {
        /** @var string $deviceToken */
        $deviceToken = $this->get('device_token');
        return $deviceToken;
    }

    public function getRole(): RoleValueObject
    {
        if (!$this->hasRole()) {
            throw new InvalidArgumentException("Role type parameter not found");
        }
        /** @var string $roleType */
        $roleType = $this->get('roleType');

        return new RoleValueObject($roleType);
    }

    public function hasRole(): bool
    {
        return $this->get('roleType') !== null;
    }

    public function getEmail(): Email
    {
        if (!$this->hasEmail()) {
            throw new InvalidArgumentException("Email not found");
        }
        /** @var string $email */
        $email = $this->get('email');

        return new Email($email);
    }

    public function hasEmail(): bool
    {
        return $this->get('email') !== null;
    }

    public function getPassword(): string
    {
        /** @var string $password */
        $password = $this->get('password');
        return $password;
    }
}
