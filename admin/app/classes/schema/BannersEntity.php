<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $banner
 * @property int $image
 * @property string $title
 * @property string $alt
 * @property int $pos
 * @property int $lang
 * @property string $link
 * @property LanguagesEntity $languages
 * @property UploadsEntity $uploads
 */
class BannersEntity extends Entity
{
}
