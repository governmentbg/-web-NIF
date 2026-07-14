<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;
use vakata\files\File;

/**
 * @property int $gallery
 * @property int $lang
 * @property string $fordate
 * @property string $title
 * @property string $content
 * @property int $hidden
 * @property string $visible_beg
 * @property ?string $visible_end
 * @property ?int $site
 * @property \vakata\collection\Collection<int,TagsEntity> $tags via gallery_tags
 * @property LanguagesEntity $languages
 * @property ?SitesEntity $sites
 * @property \vakata\collection\Collection<int,GalleryImagesEntity> $gallery_images
 */
class GalleriesEntity extends Entity
{
    /**
     * @return array<int,File>
     */
    public function images(): array
    {
        return $this->relatedRows('gallery_images')
            ->sortBy(function (Entity $a, Entity $b): int {
                return $a->pos <=> $b->pos;
            })
            ->map(function (Entity $i): ?File {
                return $i->uploads?->file();
            })
            ->compact()
            ->toArray();
    }
}
