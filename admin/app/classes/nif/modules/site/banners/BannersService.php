<?php

declare(strict_types=1);

namespace nif\modules\site\banners;

use vakata\database\schema\TableQueryMapped;
use webadmin\modules\common\crud\CRUDService;

/** @extends CRUDService<\schema\BannersEntity> */
class BannersService extends CRUDService
{
    public function entities(): TableQueryMapped
    {
        return parent::entities()
            ->filter('lang', array_keys($this->user->languages));
    }
    /**
     * @return array<int,string>
     */
    public function getLanguages(): array
    {
        return $this->user->languages;
    }
}
