<?php

declare(strict_types=1);

namespace nif\modules\banners;

use vakata\collection\Collection;
use vakata\database\DBInterface;
use vakata\database\schema\TableQueryMapped;

class BannersService
{
    public function __construct(protected DBInterface $db)
    {
    }
    /**
     * @psalm-suppress all
     * @return TableQueryMapped<\schema\BannersEntity>
     */
    protected function repository(int $lang): TableQueryMapped
    {
        /** @psalm-suppress all */
        return $this->db->tableMapped('banners')
            ->filter('lang', $lang)
            ->with('uploads')
            ->sort('pos');
    }
    /**
     * @return Collection<int,\schema\BannersEntity>
     */
    public function listing(int $lang): Collection
    {
        return $this->repository($lang)
            ->collection([ 'banner', 'image', 'title', 'alt', 'link' ]);
    }
}
