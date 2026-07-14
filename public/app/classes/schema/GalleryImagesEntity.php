<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $gallery
 * @property int $upload
 * @property int $pos
 * @property GalleriesEntity $galleries
 * @property UploadsEntity $uploads
 */
class GalleryImagesEntity extends Entity
{
}
