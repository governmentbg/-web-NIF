<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $lang
 * @property string $code
 * @property string $name
 * @property string $local
 * @property \vakata\collection\Collection<int,SitesEntity> $sites via site_lang
 * @property \vakata\collection\Collection<int,UsersEntity> $users via user_lang
 * @property \vakata\collection\Collection<int,BannersEntity> $banners
 * @property \vakata\collection\Collection<int,DocumentsCategoriesEntity> $documents_categories
 * @property \vakata\collection\Collection<int,DocumentsEntity> $documents
 * @property \vakata\collection\Collection<int,GalleriesEntity> $galleries
 * @property \vakata\collection\Collection<int,NewsEntity> $news
 * @property \vakata\collection\Collection<int,SearchIndexEntity> $search_index
 * @property \vakata\collection\Collection<int,TagsEntity> $tags
 * @property \vakata\collection\Collection<int,TreeDataEntity> $tree_data
 * @property \vakata\collection\Collection<int,TreeDataPubEntity> $tree_data_pub
 * @property \vakata\collection\Collection<int,InfoblocksEntity> $infoblocks
 * @property \vakata\collection\Collection<int,NewsCategoriesEntity> $news_categories
 * @property \vakata\collection\Collection<int,ProgramCategoriesEntity> $program_categories
 * @property \vakata\collection\Collection<int,ProgramsEntity> $programs
 */
class LanguagesEntity extends Entity
{
}
