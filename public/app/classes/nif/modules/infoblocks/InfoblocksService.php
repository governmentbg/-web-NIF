<?php

declare(strict_types=1);

namespace nif\modules\infoblocks;

use schema\InfoblocksEntity;
use vakata\collection\Collection;
use vakata\database\DBInterface;
use vakata\database\schema\TableQueryMapped;

class InfoblocksService
{
    public function __construct(protected DBInterface $db)
    {
    }
    /**
     * @psalm-suppress all
     * @return TableQueryMapped<InfoblocksEntity>
     */
    public function repo(): TableQueryMapped
    {
        /** @psalm-suppress all */
        return $this->db->tableMapped('infoblocks')
            ->filter('hidden', 0);
    }
    /**
     * @return Collection<int,InfoblocksEntity>
     */
    public function blocks(int $lang, array $infoblocks): Collection
    {
        if (!count($infoblocks)) {
            $infoblocks = null;
        }
        return $this->repo()
            ->filter('lang', $lang)
            ->filter('infoblock', $infoblocks)
            ->collection(['title', 'page_url', 'description', 'icon']);
    }
}
