<?php

declare(strict_types=1);

namespace webpublic\components;

use vakata\phptree\Tree;

class Site
{
    protected int $id;
    protected string $name;
    protected string $domain;
    protected string $homepage;
    /** @var array<int|string,array<string,mixed>> $pages */
    protected array $pages;
    /** @var array<int|string,string> $redirects */
    protected array $redirects;
    /** @var array<int,Language> $languages*/
    protected array $languages;
    /** @var array<int,Tree> $trees */
    protected array $trees;
    /** @var array<int,TemplateConfig> $templates */
    protected array $templates;
    /** @var array<int|string,Menu> $menus */
    protected array $menus;

    /**
     * @param array<string,mixed> $data
     */
    public function __construct(array $data)
    {
        $this->id = (int)$data['site'];
        $this->name = $data['name'] ?? '';
        $this->domain = $data['domain'] ?? 'localhost';
        $this->homepage = $data['homepage'] ?? '';
        $this->pages = $data['pages'];
        $this->redirects = $data['redirects'];
        $this->languages = [];
        $this->trees = [];
        foreach ($data['languages'] as $language) {
            $this->languages[(int)$language['lang']] = new Language(
                $language['lang'],
                $language['code'],
                $language['name']
            );
            $this->trees[(int)$language['lang']] = $language['tree'];
        };

        $this->templates = [];
        foreach ($data['templates'] as $template) {
            $this->templates[(int)$template['template']] = new TemplateConfig(
                $template['template'],
                $template['base'],
                $template['zones'],
                $template['widgets']
            );
        }

        $this->menus = [];
        foreach ($data['menus'] as $menu) {
            $this->menus[(int)$menu['menu']] = new Menu($menu['items']);
            if ($menu['slug']) {
                $this->menus[((string)$menu['lang']) . '_' . $menu['slug']] = $this->menus[(int)$menu['menu']];
            }
            if ($menu['is_default']) {
                $this->menus['_' . ((string)$menu['lang'])] = $this->menus[(int)$menu['menu']];
            }
        }
    }
    public function id(): int
    {
        return $this->id;
    }
    public function name(): string
    {
        return $this->name;
    }
    public function domain(): string
    {
        return $this->domain;
    }
    /**
     * @return array<int,Language>
     */
    public function languages(): array
    {
        return $this->languages;
    }
    public function getRedirect(string $url): ?string
    {
        return $this->redirects[$url] ?? null;
    }
    public function getPageFromUrl(string $url): ?Page
    {
        if ($url === '') {
            $url = $this->homepage;
        }
        $url = trim($url, '/');
        $match = $this->pages[$url] ?? null;
        if (!$match) {
            foreach ($this->pages as $purl => $data) {
                $purl = (string)$purl;
                if (
                    strpos($purl, '*') &&
                    strpos($url, trim($purl, '/*')) === 0 &&
                    (!isset($match) || strlen($match['url'] ?? '') < strlen($purl))
                ) {
                    $match = $data + [ 'url' => $purl ];
                }
            }
        }
        if (!$match) {
            return null;
        }
        return $this->getPage($match['id'], $match['lang']);
    }
    public function getPage(int $id, int $lang): ?Page
    {
        if (!isset($this->trees[$lang])) {
            return null;
        }
        $node = $this->trees[$lang]->getNode($id);
        if (!isset($node) || !$node->template || !isset($this->templates[$node->template])) {
            return null;
        }
        return new Page(
            $this,
            $this->languages[$lang],
            $node,
            $this->menus[$node->menu] ?? $this->menus['_' . (string)$lang] ?? new Menu([]),
            $this->templates[$node->template]
        );
    }
    public function getHomepage(?int $lang = null): ?Page
    {
        if (!$lang) {
            return $this->getPageFromUrl('');
        }
        return $this->getPage($this->trees[$lang]->getRoot()->id, $lang);
    }
    public function getSitemap(?int $lang = null): Menu
    {
        $page = $this->getHomepage($lang);
        return $page === null ?
            new Menu([]) :
            new Menu([
                [
                    'url' => rtrim($page->url(), '*'),
                    'text' => $page->title(),
                    'children' => $page->children(999)->toArray()
                ]
            ]);
    }
    public function getMenu(int $menu): ?Menu
    {
        return $this->menus[$menu] ?? null;
    }
    public function getMenuByName(int $lang, string $name): ?Menu
    {
        return $this->menus[((string)$lang) . '_' . $name] ?? null;
    }
}
