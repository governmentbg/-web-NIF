<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $news
 * @property int $type
 * @property int $pos
 * @property NewsCategoriesEntity $news_categories
 * @property NewsEntity $news_news
 */
class NewsTypesEntity extends Entity
{
}
