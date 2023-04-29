<?php

declare(strict_types=1);

namespace Common\Exception;

class InvalidArgumentException extends ApiException
{
    /**
     * @param string $message
     * @param int $httpCode
     * @param array<mixed> $extraParams
     */
    public function __construct(
        string $message,
        int $httpCode = 400,
        array $extraParams = []
    ) {
        parent::__construct($message, $httpCode, $extraParams);
    }
}
