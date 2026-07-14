<?php

declare(strict_types=1);

namespace nif\modules\news;

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
    protected function repository(int $lang): TableQueryMapped
    {
        /** @psalm-suppress all */
        return $this->db->tableMapped('news')
            ->filter('site', $this->site->id())
            ->filter('lang', $lang)
            ->with('uploads')
            ->where(
                'hidden = 0 AND visible_beg <= ? AND (visible_end IS NULL OR visible_end >= ?)',
                [ date('Y-m-d H:i:s'), date('Y-m-d H:i:s') ]
            );
    }
    /**
     * @return array{count:int,items:Collection<int,NewsEntity>}
     */
    public function top(int $lang, array $categories = [], array $tags = [], int $limit = 6): array
    {
        $repo = $this->repository($lang)
            ->limit($limit)
            ->limitOnMainTable(true)
            ->with('news_types')
            ->sort('fordate', true);

        if (count($tags)) {
            $repo->filter('tags.tag', $tags);
        }
        if (count($categories)) {
            $repo->filter('news_types.type', $categories);
        }

        return [
            'count' => $repo->count(),
            'items' => $repo->collection([ 'title', 'fordate', 'image', 'description' ])
        ];
    }
    /**
     * @param integer $lang
     * @param integer $id
     * @return ?NewsEntity
     */
    public function single(int $lang, int $id, array $categories = []): ?NewsEntity
    {
        /** @var ?NewsEntity $item */
        $item = $this->repository($lang)
            ->filter('news', $id)
            ->with('news_files', true, 'pos')
            ->with('news_files.uploads')
            ->with('news_images', true, 'pos')
            ->with('news_images.uploads')
            ->select()[0] ?? null;

        if ($item) {
            $temp = $this->repository($lang)
                ->where('fordate >= ?', [ $item->fordate ])
                ->order('fordate ASC, news DESC')
                ->filter('news', $id, true)
                ->limit(1, 0);
            if (count($categories)) {
                $temp->filter('news_types.type', $categories);
            }
            $item->setPrev($temp->select([ 'title' ])[0] ?? null);

            $temp = $this->repository($lang)
                ->where('fordate <= ?', [ $item->fordate ])
                ->order('fordate DESC, news DESC')
                ->filter('news', $id, true)
                ->limit(1, 0);
            if (count($categories)) {
                $temp->filter('news_types.type', $categories);
            }
            $prev = $item->getPrev();
            if ($prev) {
                $temp->filter('news', $prev->news, true);
            }
            $item->setNext($temp->select([ 'title' ])[0] ?? null);
        }
        return $item;
    }
    /**
     * @return array{count:int,items:Collection<int,NewsEntity>}
     */
    public function listing(
        int $lang,
        array $categories = [],
        array $tags = [],
        int $page = 1,
        int $perpage = 10,
        string $order_by = 'fordate',
        int $order_direction = 1
    ): array {
        $direction = $order_direction === 0 ? false : true;
        $repo = $this->repository($lang)
            ->with('news_images')
            ->sort($order_by, $direction)
            ->sort('leading_news', true)
            ->paginate(max(1, $page), $perpage)
            ->limitOnMainTable(true);

        if (count($tags)) {
            $repo->filter('tags.tag', $tags);
        }
        if (count($categories)) {
            $repo->filter('news_types.type', $categories);
        }

        return [
            'count' => $repo->count(),
            'items' => $repo->collection([ 'title', 'fordate', 'image', 'description' ])
        ];
    }
}
