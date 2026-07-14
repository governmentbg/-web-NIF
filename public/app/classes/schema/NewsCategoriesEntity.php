<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $category
 * @property string $name
 * @property string $url
 * @property int $lang
 * @property LanguagesEntity $languages
 * @property \vakata\collection\Collection<int,NewsTypesEntity> $news_types
 */
class NewsCategoriesEntity extends Entity
{
}
