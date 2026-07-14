<?php

declare(strict_types=1);

namespace webpublic;

use ArrayIterator;
use base\Jobs as BaseJobs;
use vakata\downloader\Downloader;
use vakata\phptree\Tree;
use vakata\session\Native;

class Jobs extends BaseJobs
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->app = $app;
        $this->cnf = $app->config();
    }

    /**
     * @return array<array-key,array<mixed>>
     */
    public function sites(): array
    {
        $dbc = $this->app->db();
        $tree = Tree::fromDatabase(
            $dbc,
            'tree_struct',
            [
                'id'       => 'id',
                'parent'   => 'pid',
                'position' => 'pos',
                'level'    => 'lvl',
                'left'     => 'lft',
                'right'    => 'rgt'
            ]
        );
        /** @var array<int,array{site:int,tree:int}> */
        $sites = $dbc->all(
            "SELECT site, tree FROM sites s WHERE s.disabled = 0 ORDER BY s.dflt DESC",
            null,
            'site'
        );
        $domains = $dbc->all(
            "SELECT site, domain FROM site_domain WHERE site IN(??)",
            [ array_keys($sites) ],
            'domain',
            true
        );
        $treeArray = $tree->toArray(false);
        foreach ($treeArray as $k => $node) {
            $treeArray[$k] = $node['data'];
        }
        $treeArray = array_values($treeArray);
        usort($treeArray, function ($a, $b) {
            return $a['pid'] < $b['pid'] ? -1 : ($a['pid'] > $b['pid'] ? 1 : ($a['pos'] <=> $b['pos']));
        });
        $pages = $dbc->all(
            "SELECT d.url, d.id, d.lang, d.hidden, d.title, d.redirect, d.template, d.menu, d.settings, d.created
             FROM tree_data_pub d
             WHERE d.published = 1"
        );
        foreach ($pages as $k => $v) {
            unset($pages[$k]['created']);
        }
        $menus = $dbc->all(
            "SELECT menu, site, lang, is_default, slug, items FROM menus",
            null,
            'menu'
        );
        foreach ($sites as $site => $data) {
            if (!(int)$site) {
                continue;
            }
            $sites[$site]['domains'] = [];
            foreach ($domains as $domain => $s) {
                if ($site === $s) {
                    $sites[$site]['domains'][] = $domain;
                }
            }
            $sites[$site]['redirects'] = $dbc->all(
                "SELECT url_from, url_to FROM redirects WHERE site = ?",
                $data['site'],
                'url_from',
                true
            );
            $sites[$site]['languages'] = $dbc->all(
                "SELECT l.lang, l.code, l.name, l.local FROM languages l, site_lang sl
                 WHERE l.lang = sl.lang AND sl.site = ?
                 ORDER BY l.lang",
                $data['site'],
                'lang'
            );
            $sites[$site]['language'] = array_keys($sites[$site]['languages'])[0];
            foreach (array_keys($sites[$site]['languages']) as $lang) {
                $ltree = Tree::fromAdjacencyArray($treeArray, 'id', 'pid', 'pos', $data['tree'], false);
                $ltree->remap();
                foreach ($pages as $page) {
                    if ($page['lang'] === $lang) {
                        $url = trim($page['url'], '/');
                        $node = $ltree->getNode($page['id'], false);
                        if ($node) {
                            if ((int)$page['hidden']) {
                                $node->remove();
                            } else {
                                if (!(int)$page['menu']) {
                                    foreach ($menus as $menu) {
                                        if (
                                            (int)$menu['is_default'] &&
                                            (int)$menu['lang'] === $lang &&
                                            (int)$menu['site'] === (int)$data['site']
                                        ) {
                                            $page['menu'] = $menu['menu'];
                                        }
                                    }
                                }
                                foreach ($page as $k => $v) {
                                    $node->{$k} = $v;
                                }
                                if (
                                    (int)$page['id'] === (int)$data['tree'] &&
                                    (int)$page['lang'] === $sites[$site]['language']
                                ) {
                                    $sites[$site]['homepage'] = $url;
                                }
                                $sites[$site]['pages'][$url] = [
                                    'lang' => $page['lang'],
                                    'id' => $page['id']
                                ];
                            }
                            if ($page['redirect']) {
                                $sites[$site]['redirects'][$url] = $page['redirect'];
                            }
                        }
                    }
                }
                $sites[$site]['languages'][$lang]['tree'] = $ltree;
            }
        }
        $getMenu = function (int $lang, int $id, int $depth, Tree $tree) use (&$getMenu): array {
            if (!$depth) {
                return [];
            }
            $children = [];
            foreach ($tree->getNode($id, false)?->getChildren() ?? [] as $child) {
                $url = rtrim($child->url, '/*');
                if (strlen(trim($child->redirect))) {
                    $url = trim($child->redirect);
                }
                $children[] = [
                    'id' => $child->id,
                    'url' => $url,
                    'text' => $child->title,
                    'children' => $getMenu($lang, (int)$child->id, $depth - 1, $tree)
                ];
            }
            return $children;
        };
        foreach ($sites as $site => $data) {
            $sites[$site]['menus'] = [];
            foreach ($menus as $k => $menu) {
                if ((int)$menu['site'] !== (int)$data['site']) {
                    continue;
                }
                $tmenu = $menu;
                $items = json_decode($tmenu['items'], true);
                $tmenu['items'] = [];
                /** @psalm-suppress PossiblyNullArrayAccess */
                $mtree = $data['languages'][(int)$menu['lang']]['tree'] ?? null;
                if ($mtree) {
                    foreach ($items as $item) {
                        if ($item['type'] === 'text') {
                            $tmenu['items'][] = [
                                'id'        => null,
                                'url'       => rtrim(($item['href'] ?? '#') ?: '#', '/*'),
                                'text'      => $item['name'] ?? '',
                                'children'  => []
                            ];
                        } else {
                            $mnode = $mtree->getNode((int)$item['type'], false);
                            if (!$mnode) {
                                continue;
                            }
                            $tmenu['items'][] = [
                                'id' => $item['type'],
                                'url' => $item['href'] ?: rtrim($mnode->url, '/*'),
                                'text' => $item['name'] ?: $mnode->title,
                                'children' => $getMenu(
                                    (int)$menu['lang'],
                                    (int)$item['type'],
                                    (int)$item['depth'],
                                    $mtree
                                )
                            ];
                        }
                    }
                }
                $sites[$site]['menus'][$menu['menu']] = $tmenu;
            }
        }
        $templates = $dbc->all("SELECT template, base, zones, widgets FROM templates", null, 'template');
        foreach ($templates as $template => $data) {
            $templates[$template]['zones'] = json_decode($data['zones'] ?? '[]', true) ?? [];
            $templates[$template]['widgets'] = json_decode($data['widgets'] ?? '[]', true) ?? [];
        }
        foreach ($sites as $site => $data) {
            $sites[$site]['templates'] = $templates;
        }
        $sites['domains'] = $domains;
        return $sites;
    }
    public function cacheClean(): void
    {
        $cache = $this->app->cache();
        $sites = $this->sites();
        $cache->clear();
        $cache->set('sites', $sites);
    }
    public function permissions(): void
    {
        parent::permissions();
        $static = $this->cnf->getString('STORAGE_STATIC');
        if (!is_dir($static)) {
            @mkdir($static, 0777, true);
        }
        if (is_dir($static)) {
            @chmod($static, 0777);
        }
    }
    public function index(?string $site = null): void
    {
        $dbc = $this->app->db();
        $langs = $dbc->all("SELECT lang, code FROM languages", null, 'code', true);
        $search = $this->cnf->getBool('SEARCH');
        $static = $this->cnf->getBool('STATIC');
        foreach ($this->app->cache()->get('sites') as $s => $d) {
            if ($s === 'domains') {
                continue;
            }
            if (isset($site) && !in_array($site, $d['domains'])) {
                continue;
            }
            $s = $d['domains'][0] ?? 'localhost';

            if ($search) {
                $dbc->query("UPDATE search_index SET remove = 1 WHERE site = ?", $d['site']);
            }

            $s = preg_replace('(^https?://)', '', (string)$s) ?? 'localhost';
            $dir = rtrim($this->app->config()->getString('STORAGE_STATIC'), '/') . '/' . rtrim($s, '/');
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }
            Downloader::emptyDir($dir);

            $s = explode('/', $s, 2);
            $s[1] = $s[1] ?? '/';

            $c = null;
            $u = null;
            if ($search) {
                $c = $dbc->prepare(
                    'INSERT INTO search_index (si, url, title, data, meta, indexed, site, lang)
                     VALUES (?,?,?,?,?,?,?,?)'
                );
                $u = $dbc->prepare(
                    'UPDATE search_index
                    SET url = ?, title = ?, data = ?, meta = ?, indexed = ?, site = ?, lang = ?, remove = 0
                    WHERE si = ?'
                );
            }

            $downloader = new Downloader(
                'http://' . $s[0] . $s[1],
                function (string $url) use ($s): string {
                    static $stack;
                    if (!$stack) {
                        // prevent parsing request from globals
                        $this->app->di()->register(\vakata\http\Request::fromString(
                            'GET ' . $s[1] . ' HTTP/1.1' . "\r\n" .
                            'Host: ' . $s[0] . "\r\n"
                        ));
                        $this->app->url()->setBasePath($s[1])->withHost($s[0]);
                        // mock session
                        $this->app->di()->register(new Native());
                        $stack = iterator_to_array($this->app->stack());
                    }
                    $url = preg_replace('(^https?://)', '', $url) ?? 'localhost';
                    $url = explode('/', $url, 2);
                    $req = \vakata\http\Request::fromString(
                        'GET /' . ltrim($url[1] ?? '/', '/') . ' HTTP/1.1' . "\r\n" .
                        'Host: ' . $url[0] . "\r\n"
                    );
                    $req->getUrl()->setBasePath($s[1]);
                    $res = $this->app->run(new ArrayIterator($stack), $req);
                    if ($res->getStatusCode() !== 200) {
                        throw new \RuntimeException('Could not fetch');
                    }
                    return (string)$res->getBody();
                },
                function (string $url, string $data) use ($dbc, $langs, $d, $c, $u, $search, $static): bool {
                    if ($search && $c && $u) {
                        if (strpos($data, '<html') === false) {
                            return true;
                        }
                        $lang = 'bg';
                        if (preg_match('( lang="([a-z]{2})")i', $data, $m)) {
                            $lang = $m[1];
                        }
                        if (!isset($langs[$lang])) {
                            $lang = 'bg';
                        }
                        $title = '';
                        if (
                            preg_match(
                                '(' . preg_quote('<title') . '[^>]*>(.*?)' . preg_quote('</title') . ')i',
                                $data,
                                $m
                            )
                        ) {
                            $title = $m[1];
                        }
                        $meta = [];
                        if (
                            preg_match_all(
                                '(' .
                                    preg_quote('<script type="index/json">') . '(.*?)' . preg_quote('</script>') .
                                ')sui',
                                $data,
                                $tags
                            )
                        ) {
                            foreach ($tags[1] as $match) {
                                $temp = @json_decode($match, true);
                                if ($temp) {
                                    $meta = array_merge($meta, $temp);
                                }
                            }
                        }
                        $tmp = parse_url($url) ?: [];
                        $url = ($tmp['path'] ?? '/') . (isset($tmp['query']) ? '?' . $tmp['query'] : '');
                        $si = sha1($url);
                        if ($dbc->one("SELECT 1 FROM search_index WHERE si = ?", $si)) {
                            $u->execute([
                                $url,
                                $title,
                                $data,
                                json_encode($meta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                                date('Y-m-d H:i:s'),
                                $d['site'],
                                $langs[$lang],
                                $si
                            ]);
                        } else {
                            $c->execute([
                                $si,
                                $url,
                                $title,
                                $data,
                                json_encode($meta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                                date('Y-m-d H:i:s'),
                                $d['site'],
                                $langs[$lang]
                            ]);
                        }
                    }
                    return $static;
                }
            );

            // handle assets
            Downloader::copyDir(__DIR__ . '/../../../public/assets/', $dir . '/assets/');
            $downloader
                ->filter(function (string $url) {
                    return strpos($url, 'assets/') === false;
                })
                ->rewrite(function (string $url) {
                    if (strpos($url, '/assets/') !== false) {
                        return preg_replace('(\.([0-9]+)\.(js|jpg|png|jpeg|gif|css))i', '.$2', $url);
                    }
                    return $url;
                });

            // handle uploads
            // $downloader
            //     ->rewrite(function (string $url) {
            //         if (strpos($url, '/upload/') !== false) {
            //             return preg_replace('(upload/(\d+)/.*(\.[a-z0-9]+)$)ui', 'upload/$1$2', $url);
            //         }
            //     })
            //     ->filter(function (string $url) {
            //         return strpos($url, 'upload/') === false;
            //     });

            $downloader
                ->download($dir);

            $dbc->query("DELETE FROM search_index WHERE remove = 1 AND site = ?", $d['site']);
        }
    }
    public function schema(): void
    {
        $this->cacheSchema();
        $schema = $this->app->db(true)->getSchema();
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
        $base = $this->cnf->getString('BASEDIR') . '/app/classes/schema/';
        $name = 'schema';
        foreach ($tables as $table) {
            if (in_array($table, $pivots)) {
                continue;
            }
            $clss = implode('', array_map('ucfirst', array_filter(explode('_', $table)))) . "Entity";
            if (!is_file($base . $clss . '.php')) {
                file_put_contents(
                    $base . $clss . '.php',
                    <<<EOF
                    <?php

                    declare(strict_types=1);

                    namespace $name;

                    use vakata\database\schema\Entity;

                    class $clss extends Entity
                    {
                    }
                    
                    EOF
                );
            }
            $prop = [];
            foreach ($schema->getTable($table)->getFullColumns() as $column) {
                $type = '';
                if ($column->isNullable()) {
                    $type .= '?';
                }
                switch ($column->getBasicType()) {
                    case 'int':
                        $type .= 'int';
                        break;
                    case 'float':
                        $type .= 'int';
                        break;
                    default:
                        $type .= 'string';
                        break;
                }
                $prop[$column->getName()] = ' * @property ' . $type . ' $' . $column->getName();
            }
            foreach ($schema->getTable($table)->getRelations() as $relation) {
                $type = implode('', array_map('ucfirst', array_filter(explode('_', $relation->table->getName()))));
                $type .= "Entity";
                if ($relation->many) {
                    $type = '\\vakata\\collection\\Collection<int,' . $type . '>';
                } else {
                    $nullable = false;
                    foreach ($relation->keymap as $own => $remote) {
                        if (
                            $relation->self->getColumn($own)?->isNullable() ||
                            $relation->table->getColumn($remote)?->isNullable()
                        ) {
                            $nullable = true;
                        }
                    }
                    if ($nullable) {
                        $type = '?' . $type;
                    }
                }
                $prop[$relation->name] = ' * @property ' . $type . ' $' . $relation->name;
                if ($relation->pivot) {
                    $prop[$relation->name] .= ' via ' . $relation->pivot->getName();
                }
            }
            $cmnt = "/**\n" . implode("\n", $prop) . "\n */";
            $data = file_get_contents($base . $clss . '.php') ?: '';
            $data = preg_replace('(/\*\*.*?\nclass )is', "\nclass ", $data) ?? '';
            $data = preg_replace("(\n+class )", "\n\n" . $cmnt . "\nclass ", $data) ?? '';
            file_put_contents($base . $clss . '.php', $data);
        }
    }
}
