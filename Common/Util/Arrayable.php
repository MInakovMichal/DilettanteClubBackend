<?php

declare(strict_types=1);

namespace Common\Util;

interface Arrayable
{
    /**
     * @return mixed[]
     */
    public function toArray(): array;
}
