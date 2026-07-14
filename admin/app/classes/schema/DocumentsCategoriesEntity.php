<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $category
 * @property string $name
 * @property int $lang
 * @property int $ord
 * @property \vakata\collection\Collection<int,DocumentsEntity> $documents via documents_types
 * @property LanguagesEntity $languages
 */
class DocumentsCategoriesEntity extends Entity
{
}
