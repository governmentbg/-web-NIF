<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $category
 * @property int $lang
 * @property string $name
 * @property int $is_active
 * @property int $sort_order
 * @property LanguagesEntity $languages
 * @property \vakata\collection\Collection<int,ProgramsEntity> $programs
 */
class ProgramCategoriesEntity extends Entity
{
    public function getTitle(): string
    {
        return $this->name;
    }
    public function getId(): int
    {
        return $this->category;
    }
}
