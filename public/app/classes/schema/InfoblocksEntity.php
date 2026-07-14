<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;
use vakata\files\File;

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
    public function getTitle(): string
    {
        return html_entity_decode($this->title);
    }
    public function getDescription(): string
    {
        return html_entity_decode($this->description);
    }
    public function getFile(): ?File
    {
        return $this->uploads?->file();
    }
    public function url(): ?string
    {
        return $this->page_url ? $this->page_url : null;
    }
}
