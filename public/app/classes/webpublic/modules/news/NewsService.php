<?php

declare(strict_types=1);

namespace webpublic\modules\news;

use schema\NewsEntity;
use vakata\collection\Collection;
use vakata\database\DBInterface;
use vakata\database\schema\TableQueryMapped;
use webpublic\components\Site;

class NewsService
{
    public function __construct(
        protected DBInterface $db,
        protected Site $site
    ) {
    }

    /**
     * @psalm-suppress all
     * @return TableQueryMapped<NewsEntity>
     */
    protected function repository(): TableQueryMapped
    {
        /** @psalm-suppress all */
        return $this->db->tableMapped('news')
            ->filter('site', $this->site->id())
            ->with('uploads')
            ->where(
                'hidden = 0 AND visible_beg <= ? AND (visible_end IS NULL OR visible_end >= ?)',
                [ date('Y-m-d H:i:s'), date('Y-m-d H:i:s') ]
            );
    }

    public function single(int $lang, int $id): ?NewsEntity
    {
        return $this->repository()
            ->filter('lang', $lang)
            ->filter('news', $id)
            ->select()[0] ?? null;
    }
    /**
     * @return array{count:int,items:Collection<int,NewsEntity>}
     */
    public function listing(int $lang, int $tag = 0, int $page = 1, int $perpage = 10): array
    {
        $repo = $this->repository()
            ->filter('lang', $lang)
            ->paginate(max(1, $page), $perpage)
            ->order('fordate DESC, news DESC');
        if ($tag) {
            $repo->filter('tags.tag', $tag);
        }
        return [
            'count' => $repo->count(),
            'items' => $repo->collection([ 'title', 'fordate', 'image' ])
        ];
    }
    /**
     * @return Collection<int,NewsEntity>
     */
    public function top(int $tag = 0, int $limit = 3): Collection
    {
        $repo = $this->repository()
            ->limit($limit)
            ->sort('fordate', true);
        if ($tag) {
            $repo->filter('tags.tag', $tag);
        }
        return $repo->collection([ 'title', 'fordate', 'image' ]);
    }
}
