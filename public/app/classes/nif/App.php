<?php

declare(strict_types=1);

namespace nif;

use nif\modules\banners\BannersWidget;
use nif\modules\documents\DocumentsChosenWidget;
use nif\modules\documents\DocumentsGroupWidget;
use nif\modules\infoblocks\InfoblockWidget;
use nif\modules\news\NewsTemplate;
use nif\modules\news\TopWidget;
use nif\modules\pages\CandidateLinkWidget;
use nif\modules\pages\ContactsTemplate;
use nif\modules\pages\HomepageTemplate;
use nif\modules\pages\PageTemplate;
use nif\modules\pages\RichtextWidget;
use nif\modules\pages\SitemapTemplate;
use nif\modules\pages\TextWidget;
use nif\modules\programs\ActiveProgramsWidget;
use nif\modules\programs\ProgramsTemplate;
use RuntimeException;
use vakata\config\Config;
use vakata\http\Request;
use vakata\http\Response;
use vakata\jwt\JWT;
use webpublic\App as WebadminPublic;
use webpublic\Jobs;
use webpublic\modules\galleries\GalleryTemplate;
use webpublic\modules\pages\SearchTemplate;
use webpublic\modules\WidgetInterface;

class App extends WebadminPublic
{
    public static function init(): self
    {
        /** @psalm-suppress InvalidArgument */
        return new self(
            (require __DIR__ . '/../../../.env.php') ?? Config::parseEnvFile(__DIR__ . '/../../../.env')
        );
    }
    public function defaults(): array
    {
        return array_merge(
            parent::defaults(),
            [
                'MAILFROM' => '',
                'SMTP_USER' => null
                //'CACHE'    => 'memcached'
            ]
        );
    }
    /**
     * @param string $name
     * @return class-string<WidgetInterface>
     */
    protected function widgetMapper(string $name): string
    {
        $map = [
            'news_top'        => TopWidget::class,
            'richtext'        => RichtextWidget::class,
            'text'            => TextWidget::class,
            'candidatelink'   => CandidateLinkWidget::class,
            'infoblocks'      => InfoblockWidget::class,
            'activeprograms'  => ActiveProgramsWidget::class,
            'banners'         => BannersWidget::class,
            'documentschosen' => DocumentsChosenWidget::class,
            'documentsgroup'  => DocumentsGroupWidget::class,
        ];
        return $map[$name] ?? throw new RuntimeException('Unknown widget' . $name);
    }
    /**
     * @param string $name
     * @return class-string
     */
    protected function templateMapper(string $name): string
    {
        $map = [
            'news'       => NewsTemplate::class,
            'gallery'    => GalleryTemplate::class,
            'page'       => PageTemplate::class,
            'searchpage' => SearchTemplate::class,
            'homepage'   => HomepageTemplate::class,
            'contacts'   => ContactsTemplate::class,
            'programs'   => ProgramsTemplate::class,
            'contact'    => ContactsTemplate::class,
            'sitemap'    => SitemapTemplate::class
        ];
        return $map[$name] ?? throw new RuntimeException('Unknown template');
    }
    public function middleware(string $class): callable
    {
        switch ($class) {
            case \base\middleware\CSP::class:
                return new \base\middleware\CSP(
                    $this->views(),
                    [
                        'default-src'    => "'self'",
                        'script-src'     => [
                            "'self'",
                            "'nonce-{__NONCE__}'",
                            "http://track.uslugi.io/matomo.js",
                        ],
                        'style-src'      => [
                            "'self'",
                            "'nonce-{__NONCE__}'"
                        ],
                        'img-src'        => [
                            "'self'",
                            "data:",
                            "blob:",
                            "http://track.uslugi.io/matomo.php"
                        ],
                        'font-src'       => ["'self'", "data:"],
                        'frame-src'      => [
                            "'self'",
                            "https://www.youtube.com",
                            "https://www.google.com",
                            "https://www.youtube-nocookie.com",
                            "https://youtube-nocookie.com"
                        ],
                        'style-src-elem' => [
                            "'self'",
                            "'unsafe-inline'"
                        ],
                        'style-src-attr' => [
                            "'unsafe-inline'"
                        ],
                        'connect-src' => [
                            "'self'",
                            "http://track.uslugi.io/matomo.php"
                        ]
                    ],
                    'csp-report'
                );
            default:
                return parent::middleware($class);
        }
    }
    public function middlewares(): array
    {
        return [
            "MIDDLEWARE_HEALTH" => \webpublic\middleware\Health::class,
            "MIDDLEWARE_GZIP" => \base\middleware\Gzip::class,
            "MIDDLEWARE_CACHE" => \base\middleware\Cache::class,
            "MIDDLEWARE_MINIFY" => \base\middleware\Minify::class,
            "MIDDLEWARE_LOGGER" => \base\middleware\Logger::class,
            "MIDDLEWARE_CLIENTIP" => \base\middleware\ClientIP::class,
            "MIDDLEWARE_FIXER" => \base\middleware\Fixer::class,
            "MIDDLEWARE_SESSION" => \base\middleware\Session::class,
            "MIDDLEWARE_HTTPS" => \base\middleware\HTTPS::class,
            "MIDDLEWARE_OWASP" => \nif\middleware\OWASP::class,
            "MIDDLEWARE_CSP" => \base\middleware\CSP::class,
            "MIDDLEWARE_FP" => \base\middleware\FP::class,
            "MIDDLEWARE_PP" => \base\middleware\PP::class,
            "MIDDLEWARE_IDS" => \base\middleware\IDS::class,
            //"MIDDLEWARE_CSRF" => \base\middleware\CSRF::class,
            "MIDDLEWARE_CORS" => \base\middleware\CORS::class,
            "MIDDLEWARE_INTL" => \base\middleware\Intl::class,
            "MIDDLEWARE_UPLOADS" => \base\middleware\Uploads::class,
            "MIDDLEWARE_TRANSACTION" => \base\middleware\Transaction::class
        ];
    }
    public function error(int $code): Response
    {
        return new Response(
            $code,
            $this->views()
            ->render(
                'nif::' . ($code >= 400 && $code < 500 ? '404' : '500')
            )
        );
    }
    public function core(Request $req): Response
    {
        $this->mail();
        /** @var array<string,mixed> $sites */
        static $sites = [];
        /** @var array<string,int> $domains */
        static $domains = [];
        try {
            if (in_array($req->getMethod(), ['HEAD', 'OPTIONS'])) {
                throw new RuntimeException('Method Not Allowed', 405);
            }
            $preview = $req->getQuery('preview') !== null;
            $token = null;
            if ($preview) {
                try {
                    $token = JWT::fromString($req->getQuery('preview'), $this->config->getString('ENCRYPTIONKEY'));
                    if (
                        !$token->isValid() ||
                        !$token->isSigned() ||
                        !$token->verify($this->config->getString('SIGNATUREKEY'))
                    ) {
                        throw new RuntimeException();
                    }
                } catch (\Exception $e) {
                    throw new RuntimeException('Invalid preview token', 403);
                }
            }
            if (!count($sites)) {
                $sites = $this->cache()->getSet(
                    'sites' . ($preview ? '.preview' : ''),
                    function (): array {
                        return $this->di()->instance(Jobs::class)->sites();
                    }
                );
                $domains = $sites['domains'];
                unset($sites['domains']);
            }
            $match = null;
            $host = $req->getUrl()->getHost() ?: 'default';
            $path = trim($req->getUrl()->getPath(), '/');
            foreach ($domains as $domain => $site) {
                $temp = explode('/', $domain, 2);
                $sdomain = $temp[0];
                $sprefix = $temp[1] ?? null;
                if ($sdomain !== $host) {
                    continue;
                }
                if (
                    (!isset($sprefix) || strpos($path, $sprefix) === 0) &&
                    (!isset($match) || strlen($match) < strlen($domain))
                ) {
                    $match = $site;
                }
            }
            if (!$match) {
                $match = array_keys($sites)[0];
            }
            if (!isset($domain) || !in_array($domain, $sites[$match]['domains'])) {
                $domain = $sites[$match]['domains'][0];
            }
            $sites[$match]['domain'] = $domain;
            $site = $this->site($sites[$match]);
            if (strpos($host, '/')) {
                $temp = explode('/', $match, 2);
                $this->url()->setBasePath($temp[1] ?? null);
            }
            $url = mb_strtolower(trim($this->url()->getRealPath(true), '/'));
            if ($redirect = $site->getRedirect($url)) {
                $redirect = preg_match('(^(http|/))', $redirect) ?
                    $redirect :
                    $this->url()->get($redirect);
                return (new Response(303, null, ['Location' => $redirect ]));
            }
            $page = $site->getPageFromUrl($url);
            if (!$page) {
                throw new RuntimeException('Page not found', 404);
            }
            if (
                $token &&
                ($token->getClaim('id') !== $page->id() || $token->getClaim('lang') !== $page->language()->lang())
            ) {
                throw new RuntimeException('Invalid token', 403);
            }
            $turl = clone $req->getUrl();
            $turl->setBasePath(rtrim($turl->getBasePath(true), '/') . '/' . ltrim($page->url(), '/'));
            $this->views()->addData([
                'turl' => $turl
            ]);
            $req = $req->withAttribute('turl', $turl);
            $this->di()->register($site);
            $this->di()->register($page);

            // make sure there is a schema
            $this->db(true);
            // register mappers
            $this->mappers();

            // setup translations
            $intl = $this->intl();
            $lang = $page->language()->code();
            $path = $this->config->getString('STORAGE_INTL') . '/';
            if (is_file($path . $lang . '.json.php')) {
                /** @psalm-suppress UnresolvableInclude */
                $temp = include $path . $lang . '.json.php';
                $intl->addArray($temp);
            } elseif (is_file($path . $lang . '.json')) {
                $intl->addFile($path . $lang . '.json');
            }
            $overrides = $this->cache()->getSet('translations', function () {
                $all = [];
                foreach ($this->db()->all("SELECT * FROM translations_public") as $row) {
                    $all[$row['locale']][$row['k']] = (string)$row['v'];
                }
                return $all;
            });
            /** @phpstan-ignore-next-line */
            $intl->addArray(array_filter($overrides[$lang] ?? []));

            $content = $preview && $token ?
                (string)$this->db()->val(
                    "SELECT content FROM tree_data WHERE id = ? AND lang = ? AND version = ?",
                    [ $page->id(), $page->language()->lang(), $token->getClaim('version') ]
                ) :
                (string)$this->db()->val(
                    "SELECT content FROM tree_data_pub WHERE id = ? AND lang = ?",
                    [ $page->id(), $page->language()->lang() ]
                );
            $content = json_decode($content, true) ?? [];
            $page->template()->addWidgets($content['widgets'] ?? []);
            $page->template()->addParams($content[(string)$page->template()->id()] ?? []);
            $res = $this->di()->invoke($this->template($page), strtolower($req->getMethod()));
            if ($preview || (int)$page->getSetting('nocache')) {
                $res->withAddedHeader('X-No-Cache', '1');
            }
            return $res;
        } catch (\Throwable $e) {
            $code = (int)($e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
            if ($code >= 500) {
                $this->logger()->addCritical($e->getMessage());
            }
            return $this->error($code);
        }
    }
}
