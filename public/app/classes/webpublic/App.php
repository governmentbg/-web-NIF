<?php

declare(strict_types=1);

namespace webpublic;

use base\App as BaseApp;
use vakata\views\Views;
use RuntimeException;
use schema\mappers\DIMapper;
use vakata\config\Config;
use vakata\files\File;
use vakata\http\Request;
use vakata\http\Response;
use vakata\jwt\JWT;
use webpublic\components\Page;
use webpublic\components\ParamsContainer;
use webpublic\components\Site;
use webpublic\components\TemplateConfig;
use webpublic\components\WidgetConfig;
use webpublic\modules\galleries\GalleryTemplate;
use webpublic\modules\news\NewsTemplate;
use webpublic\modules\news\TopWidget;
use webpublic\modules\pages\HomepageTemplate;
use webpublic\modules\pages\PageTemplate;
use webpublic\modules\pages\SearchTemplate;
use webpublic\modules\pages\RichtextWidget;
use webpublic\modules\pages\TextWidget;
use webpublic\modules\TemplateInterface;
use webpublic\modules\WidgetInterface;

class App extends BaseApp
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
        $dir = realpath(__DIR__ . '/../../../') ?: throw new \RuntimeException();
        return array_merge(
            parent::defaults(),
            [
                'HEALTH_URL'            => 'health',
                'SEARCH'                => true,
                'STATIC'                => true,
                'MIDDLEWARE_CACHE'      => false,
                'MIDDLEWARE_HEALTH'     => true,
                'DB_CONFIG'             => false,
                'MIDDLEWARE_INTL'       => false,
                'STORAGE_INTL'          => $dir . '/storage/intl/public',
                'STORAGE_STATIC'        => $dir . '/storage/static'
            ]
        );
    }

    public function views(): Views
    {
        if (!$this->container->has(Views::class)) {
            $views = parent::views();
            $views->addFolder(
                'webpublic',
                realpath($this->config->getString('BASEDIR') . '/app/views/webpublic') ?: throw new \RuntimeException()
            );
            $ns = explode('\\', static::class)[0];
            if ($ns !== 'webpublic' && is_dir($this->config->getString('BASEDIR') . '/app/views/' . $ns)) {
                $views->addFolder(
                    $ns,
                    realpath($this->config->getString('BASEDIR') . '/app/views/' . $ns) ?: throw new \RuntimeException()
                );
            }
            $views->addData([
                'url' => $this->url(),
                'intl' => $this->intl()
            ]);
        }
        return $this->container->get(Views::class);
    }

    public function middleware(string $class): callable
    {
        switch ($class) {
            case \webpublic\middleware\Health::class:
                return new \webpublic\middleware\Health(
                    $this->config,
                    $this->db(true),
                    $this->cache(),
                    $this->config->getString('HEALTH_URL')
                );
            case \base\middleware\Cache::class:
                return new \base\middleware\Cache(
                    $this->cache(),
                    $this->config()->getInt('CACHE_RESPONSE_TTL'),
                    $this->config()->getInt('CACHE_RESPONSE_MAX_SIZE'),
                    function (Request $req): ?string {
                        $url = (string)$req->getUrl();
                        if (strpos($url, '/' . $this->config->getString('UPLOAD_URL') . '/')) {
                            return null;
                        }
                        return sha1($req->getMethod() . ' ' . $url);
                    }
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
            "MIDDLEWARE_OWASP" => \base\middleware\OWASP::class,
            "MIDDLEWARE_CSP" => \base\middleware\CSP::class,
            "MIDDLEWARE_FP" => \base\middleware\FP::class,
            "MIDDLEWARE_PP" => \base\middleware\PP::class,
            "MIDDLEWARE_IDS" => \base\middleware\IDS::class,
            "MIDDLEWARE_CORS" => \base\middleware\CORS::class,
            "MIDDLEWARE_INTL" => \base\middleware\Intl::class,
            "MIDDLEWARE_UPLOADS" => \base\middleware\Uploads::class,
            "MIDDLEWARE_TRANSACTION" => \base\middleware\Transaction::class
        ];
    }
    public function error(int $code): Response
    {
        return new Response($code, (string)$code);
    }
    /**
     * @param string $name
     * @return class-string
     */
    protected function templateMapper(string $name): string
    {
        $map = [
            'news' => NewsTemplate::class,
            'gallery' => GalleryTemplate::class,
            'page' => PageTemplate::class,
            'searchpage' => SearchTemplate::class,
            'homepage' => HomepageTemplate::class
        ];
        return $map[$name] ?? throw new RuntimeException('Unknown template');
    }
    public function template(Page $page): object
    {
        $widgets = [];
        foreach ($page->template()->zones() as $name) {
            $widgets[$name] = [];
            foreach ($page->template()->widgets($name) as $widget) {
                $widgets[$name][] = $this->widget($widget);
            }
        }
        $params = $page->template()->params();
        return $this->di()->instance(
            $this->templateMapper($page->template()->name()),
            [
                'page' => $page,
                'params' => new ParamsContainer($params, $this->files()),
                'widgets' => $widgets
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
            'news_top' => TopWidget::class,
            'richtext' => RichtextWidget::class,
            'text' => TextWidget::class
        ];
        return $map[$name] ?? throw new RuntimeException('Unknown widget' . $name);
    }
    public function widget(WidgetConfig $config): WidgetInterface
    {
        return $this->di()->instance($this->widgetMapper($config->name()), [ 'params' => $config->params() ]);
    }
    protected function mappers(): void
    {
        $dbc = $this->db(true);
        $schema = $dbc->getSchema();

        $tables = [];
        $pivots = [];
        foreach ($schema->getTables() as $table) {
            $tables[] = $table->getName();
            foreach ($table->getRelations() as $relation) {
                $pivots[] = $relation->pivot?->getName();
            }
        }
        $tables = array_unique(array_filter($tables));
        $pivots = array_unique(array_filter($pivots));
        foreach ($tables as $table) {
            if (in_array($table, $pivots)) {
                continue;
            }
            /** @var class-string<\vakata\database\schema\Entity> $clss */
            $clss = 'schema\\' .
                implode('', array_map('ucfirst', array_filter(explode('_', $table)))) . "Entity";
            $dbc->setMapper(
                $table,
                new DIMapper($this->di(), $dbc, $table, $clss),
                $clss
            );
        }
    }
    public function site(array $data): Site
    {
        return new Site($data);
    }
    public function core(Request $req): Response
    {
        /** @var array<string,mixed> $sites */
        static $sites = [];
        /** @var array<string,int> $domains */
        static $domains = [];
        try {
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
