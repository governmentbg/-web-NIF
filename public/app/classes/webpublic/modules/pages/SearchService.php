<?php

declare(strict_types=1);

namespace webpublic\modules\pages;

use schema\SearchIndexEntity;
use vakata\database\DBInterface;
use vakata\collection\Collection;
use webpublic\components\Site;
use vakata\database\schema\TableQueryMapped;

class SearchService
{
    public function __construct(
        protected DBInterface $db,
        protected Site $site
    ) {
    }
    /**
     * @return array{count:int,items:Collection<int,SearchIndexEntity>}
     */
    public function listing(int $lang, string $q, int $page = 1, int $perpage = 10): array
    {
        switch ($this->db->driverName()) {
            case 'mysql':
                /** @var TableQueryMapped<SearchIndexEntity> $results */
                $results = $this->db->tableMapped('search_index')
                    ->where(
                        'MATCH (title, data) AGAINST (?) AND lang = ?',
                        [ $q, $lang ]
                    );
                break;
            case 'postgre':
                $dictionaries = [
                    2 => 'english'
                ];
                /** @var TableQueryMapped<SearchIndexEntity> $results */
                $results = $this->db->tableMapped('search_index')
                    ->where(
                        'tsindex @@ websearch_to_tsquery(?, ?) AND lang = ?',
                        [
                            $dictionaries[$lang] ?? 'simple',
                            $q,
                            $lang
                        ]
                    );
                break;
            default:
                /** @var TableQueryMapped<SearchIndexEntity> $results */
                $results = $this->db->tableMapped('search_index')
                    ->where(
                        '(title LIKE ? OR data LIKE ?) AND lang = ?',
                        [
                            '%' . str_replace(['%', '_'], ['\\%','\\_'], $q) . '%',
                            '%' . str_replace(['%', '_'], ['\\%','\\_'], $q) . '%',
                            $lang
                        ]
                    );
                break;
        }
        $results
            ->filter('site', $this->site->id())
            ->paginate($page, $perpage);
        return [
            'count' => $results->count(),
            'items' => $results->collection([ 'url', 'title' ])
        ];
    }
}
