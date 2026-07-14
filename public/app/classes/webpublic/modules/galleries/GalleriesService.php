<?php

declare(strict_types=1);

namespace webpublic\modules\galleries;

use vakata\collection\Collection;
use vakata\database\DBInterface;
use vakata\database\schema\TableQueryMapped;
use webpublic\components\Site;

class GalleriesService
{
    public function __construct(
        protected DBInterface $db,
        protected Site $site
    ) {
    }

    /**
     * @psalm-suppress all
     * @return TableQueryMapped<\schema\GalleriesEntity>
     */
    protected function repository(): TableQueryMapped
    {
        /** @psalm-suppress all */
        return $this->db->tableMapped('galleries')
            ->filter('site', $this->site->id())
            ->with('gallery_images.uploads')
            ->where(
                'hidden = 0 AND visible_beg <= ? AND (visible_end IS NULL OR visible_end >= ?)',
                [ date('Y-m-d H:i:s'), date('Y-m-d H:i:s') ]
            );
    }

    /**
     * @return array{count:int,items:Collection<int,\schema\GalleriesEntity>}
     */
    public function listing(int $lang, int $tag = 0, int $page = 1, int $perpage = 10): array
    {
        $repo = $this->repository()
            ->filter('lang', $lang)
            ->paginate(max(1, $page), $perpage)
            ->order('fordate DESC, gallery DESC');
        if ($tag) {
            $repo->filter('tags.tag', $tag);
        }
        return [
            'count' => $repo->count(),
            'items' => $repo->collection()
        ];
    }
}
