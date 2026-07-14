<?php

declare(strict_types=1);

namespace webpublic\components;

use vakata\phptree\Node;

class Page
{
    protected Site $site;
    protected Language $language;
    protected TemplateConfig $template;
    protected Menu $menu;
    protected Node $node;
    /** @var array<string,mixed> $settings */
    protected array $settings;
    /** @var array<string,string> $meta */
    protected array $meta;

    public function __construct(
        Site $site,
        Language $language,
        Node $node,
        Menu $menu,
        TemplateConfig $template
    ) {
        $this->site = $site;
        $this->language = $language;
        $this->template = $template;
        $this->menu = $menu;
        $this->node = $node;
        $this->settings = json_decode($node->settings, true) ?? [];
        $this->meta = [];
        foreach (json_decode($this->getSetting('meta', '[]'), true) as $row) {
            if (isset($row['tag']) && isset($row['value']) && strlen(trim($row['tag']))) {
                $this->meta[trim($row['tag'])] = $row['value'];
            }
        }
    }
    public function id(): int
    {
        return $this->node->id;
    }
    public function url(): string
    {
        return rtrim($this->node->url, '/*');
    }
    public function title(): string
    {
        return $this->node->title;
    }
    public function language(): Language
    {
        return $this->language;
    }
    public function template(): TemplateConfig
    {
        return $this->template;
    }
    public function site(): Site
    {
        return $this->site;
    }
    public function menu(?string $name = null): Menu
    {
        return $name === null ?
            $this->menu :
            ($this->site->getMenuByName($this->language->lang(), $name) ?? new Menu([]));
    }
    public function siblings(int $depth = 1): Menu
    {
        $nodes = [];
        if ($depth) {
            foreach ($this->node->getParent()?->getChildren() ?? [] as $child) {
                $temp = $this->site->getPage($child->id, $this->language->lang());
                if ($temp && $temp->inParentMenu()) {
                    $nodes[] = [
                        'url' => rtrim($temp->url(), '*'),
                        'text' => $temp->title(),
                        'children' => $temp->children($depth - 1)->toArray()
                    ];
                }
            }
        }
        return new Menu($nodes);
    }
    public function children(int $depth = 1): Menu
    {
        $nodes = [];
        if ($depth) {
            foreach ($this->node->getChildren() as $child) {
                $temp = $this->site->getPage($child->id, $this->language->lang());
                if ($temp && $temp->inParentMenu()) {
                    $nodes[] = [
                        'url' => rtrim($temp->url(), '*'),
                        'text' => $temp->title(),
                        'children' => $temp->children($depth - 1)->toArray()
                    ];
                }
            }
        }
        return new Menu($nodes);
    }
    public function breadcrumb(): Menu
    {
        $nodes = [];
        foreach (array_reverse($this->node->getAncestors()) as $child) {
            $temp = $this->site->getPage($child->id, $this->language->lang());
            if ($temp && $temp->inBreadcrumb()) {
                $nodes[] = [
                    'url' => rtrim($temp->url(), '*'),
                    'text' => $temp->title(),
                    'children' => []
                ];
            }
        }
        $nodes[] = [
            'url' => rtrim($this->url(), '*'),
            'text' => $this->title(),
            'children' => []
        ];
        return new Menu($nodes);
    }
    public function translations(bool $fallbackToRoot = true): Menu
    {
        $nodes = [];
        foreach ($this->site->languages() as $lang) {
            $temp = $this->site->getPage($this->id(), $lang->lang());
            if (!$temp && $fallbackToRoot) {
                $temp = $this->site->getHomepage($lang->lang());
            }
            if ($temp) {
                $nodes[] = [
                    'url' => rtrim($temp->url(), '*'),
                    'text' => $lang->name(),
                    'children' => []
                ];
            }
        }
        return new Menu($nodes);
    }

    public function inParentMenu(): bool
    {
        return (int)($this->node->settings['parentmenu'] ?? '1') !== 0;
    }
    public function inBreadcrumb(): bool
    {
        return (int)($this->node->settings['breadcrumb'] ?? '1') !== 0;
    }
    /**
     * @return array<string,mixed>
     */
    public function getSettings(): array
    {
        return $this->settings;
    }
    public function getSetting(string $name, mixed $default = null): mixed
    {
        return $this->getSettings()[$name] ?? $default;
    }
    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setSetting(string $name, mixed $value): static
    {
        $this->settings[$name] = $value;

        return $this;
    }
    /**
     * @return array<string,string>
     */
    public function getMeta(): array
    {
        return $this->meta;
    }
    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setMeta(string $name, string $value): static
    {
        $this->meta[$name] = $value;

        return $this;
    }
}
