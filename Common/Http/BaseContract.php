<?php

namespace Common\Http;

interface BaseContract
{
    public function getId(): int;

    public function getLanguageId(): int;
}
