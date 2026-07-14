<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $infoblock
 * @property string $title
 * @property string $description
 * @property ?int $icon
 * @property ?string $page_url
 * @property int $lang
 * @property int $hidden
 * @property LanguagesEntity $languages
 * @property ?UploadsEntity $uploads
 */
class InfoblocksEntity extends Entity
{
}
