<?php

declare(strict_types=1);

namespace Common\Auth\Sdk\Model;

use Common\Util\ArrayParser;
use Common\ValueObject\Email;
use Common\Exception\InvalidArgumentException;
use Illuminate\Support\Arr;

final class OAuthDetails
{
    /** @var string[] */
    private const REQUIRED_ATTRIBUTES = ['iss', 'aud', 'iat', 'exp', 'sub', 'email'];

    private string $issuer;

    private string $audience;

    private int $issuedAt;

    private int $expireAt;

    private string $subject;

    private ?Email $email;

    /** @var array<string,mixed> */
    private array $additionalDetails = [];

    /** @param array<string,mixed> $oAuthDetails */
    public function __construct(array $oAuthDetails)
    {
        try {
            $this->issuer = ArrayParser::getStringFromArray($oAuthDetails, 'iss');
            $this->audience = ArrayParser::getStringFromArray($oAuthDetails, 'aud');
            $this->issuedAt = ArrayParser::getIntFromArray($oAuthDetails, 'iat');
            $this->expireAt = ArrayParser::getIntFromArray($oAuthDetails, 'exp');
            $this->subject = ArrayParser::getStringFromArray($oAuthDetails, 'sub');

            /** @var ?string $email */
            $email = array_key_exists('email', $oAuthDetails) ? $oAuthDetails['email'] : null;
            $this->email = $email !== null ? new Email($email) : null;

            /**
             * @var string $key
             * @var mixed $value
             */
            foreach ($oAuthDetails as $key => $value) {
                if (in_array($key, self::REQUIRED_ATTRIBUTES, true)) {
                    continue;
                }
                $this->additionalDetails[$key] = $value;
            }
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException("Failed to construct AppleIdDetails with message: " . $exception->getMessage());
        }
    }

    public function getAudience(): string
    {
        return $this->audience;
    }

    public function getIssuer(): string
    {
        return $this->issuer;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getExpireAt(): int
    {
        return $this->expireAt;
    }

    public function getIssuedAt(): int
    {
        return $this->issuedAt;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function hasEmail(): bool
    {
        return $this->email !== null;
    }

    public function getEmail(): Email
    {
        if (!$this->hasEmail()) {
            throw new InvalidArgumentException("Email is not set");
        }
        /** @var Email */
        return $this->email;
    }

    /** @return array<string,mixed> */
    public function getAdditionalDetails(): array
    {
        return $this->additionalDetails;
    }
}
