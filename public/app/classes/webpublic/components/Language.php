<?php

declare(strict_types=1);

namespace webpublic\components;

class Language
{
    public function __construct(
        protected int $lang,
        protected string $code,
        protected string $name
    ) {
    }
    public function lang(): int
    {
        return $this->lang;
    }
    public function code(): string
    {
        return $this->code;
    }
    public function name(): string
    {
        return $this->name;
    }
}
