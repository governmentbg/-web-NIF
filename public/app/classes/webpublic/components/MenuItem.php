<?php

declare(strict_types=1);

namespace webpublic\components;

class MenuItem
{
    protected string $url;
    protected string $text;
    /** @var array<array{url: string|null, text: string|null, children: array<int, mixed>}> $children */
    protected array $children;

    /**
     * @param string $url
     * @param string $text
     * @param array<array{url: string|null, text: string|null, children: array<int, mixed>}> $children
     */
    public function __construct(string $url, string $text, array $children = [])
    {
        $this->url = $url;
        $this->text = $text;
        $this->children = $children;
    }
    public function url(): string
    {
        return $this->url;
    }
    public function text(): string
    {
        return $this->text;
    }
    public function children(): Menu
    {
        return new Menu($this->children);
    }
    public function hasChildren(): bool
    {
        return count($this->children) > 0;
    }
}
