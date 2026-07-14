<?php

declare(strict_types=1);

namespace base\middleware;

use vakata\http\Request;
use vakata\http\Response;
use vakata\intl\Intl as Translations;

class Intl
{
    protected Translations $intl;
    /** @var array<string> $langs */
    protected array $langs;
    protected string $cookieName;
    protected bool $cache;
    /** @var array<string,array<string,string>> $overrides */
    protected array $overrides;

    /**
     * @param Translations $intl
     * @param array<string> $langs
     * @param string $cookieName
     * @param boolean $cache
     * @param array<string,array<string,string>> $overrides
     */
    public function __construct(
        Translations $intl,
        array $langs = [],
        string $cookieName = '_LOCALE',
        bool $cache = false,
        array $overrides = []
    ) {
        $this->intl = $intl;
        $this->langs = $langs;
        $this->cookieName = $cookieName;
        $this->cache = $cache;
        $this->overrides = $overrides;
    }
    /**
     * @param Request $req
     * @param callable(Request):Response $next
     * @return Response
     */
    public function __invoke(Request $req, callable $next): Response
    {
        $available = array_keys($this->langs);
        $lng = strtolower(
            $req->getCookieParams()[$this->cookieName] ??
            $req->getPreferredResponseLanguage('bg', $available)
        );
        $locale = in_array($lng, $available) ? $lng : ($available[0] ?? null);
        if ($locale) {
            if ($this->cache && is_file($this->langs[$locale] . '.php')) {
                /** @psalm-suppress UnresolvableInclude */
                $lang = include $this->langs[$locale] . '.php';
            } else {
                $lang = @json_decode(file_get_contents($this->langs[$locale]) ?: '{}', true);
            }
            $lang = array_merge($lang, array_filter($this->overrides[$locale] ?? []));
            $this->intl->addArray($lang);
        }
        $req->withAttribute(
            'locale',
            $locale ? $this->intl->get('_locale.code.short', [], (string)$locale) : null
        );
        return $next($req);
    }
}
