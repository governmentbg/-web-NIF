<?php

declare(strict_types=1);

namespace webpublic\components;

class WidgetConfig
{
    /**
     * @param string $name
     * @param array<string,mixed> $params
     */
    public function __construct(
        protected string $name,
        protected array $params
    ) {
    }
    public function name(): string
    {
        return $this->name;
    }
    /**
     * @return array<string,mixed>
     */
    public function params(): array
    {
        return $this->params;
    }
    public function zone(): string
    {
        return $this->params['__zone'] ?? 'main';
    }
    public function hidden(): bool
    {
        return (int)($this->params['__hidden'] ?? '1') > 0;
    }
}
