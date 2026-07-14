<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;
use vakata\files\File;

/**
 * @property int $banner
 * @property int $image
 * @property string $title
 * @property string $alt
 * @property int $pos
 * @property int $lang
 * @property string $link
 * @property UploadsEntity $uploads
 * @property LanguagesEntity $languages
 */
class BannersEntity extends Entity
{
    public function getUrl(): string
    {
        return html_entity_decode($this->link);
    }
    public function getAlt(): string
    {
        return html_entity_decode($this->alt);
    }
    public function getImage(): ?File
    {
        return $this->uploads->file();
    }
}
