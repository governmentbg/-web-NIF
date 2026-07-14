<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $news
 * @property int $type
 * @property int $pos
 * @property NewsEntity $news_news
 * @property NewsCategoriesEntity $news_categories
 */
class NewsTypesEntity extends Entity
{
    public function getCategory(): NewsCategoriesEntity
    {
        return $this->news_categories;
    }
}
