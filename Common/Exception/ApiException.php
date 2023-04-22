<?php

declare(strict_types=1);

namespace Common\Exception;

use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class ApiException extends HttpException implements Arrayable
{
    /**
     * @var array<mixed>
     */
    protected array $extraParams = [];

    /**
     * @param string $message
     * @param int $httpCode
     * @param array<mixed> $extraParams
     */
    public function __construct(
        string $message,
        int $httpCode,
        array $extraParams = []
    ) {
        parent::__construct($httpCode, $message);
        $this->extraParams = $extraParams;
        $this->code = 0;
    }

    final public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
            'extra_params' => $this->getExtraParams(),
        ];
    }

    /**
     * @return array<mixed>
     */
    final public function getExtraParams(): array
    {
        return $this->extraParams;
    }
}
