<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;
use vakata\files\File;

/**
 * @property int $file
 * @property int $document
 * @property int $pos
 * @property DocumentsEntity $documents
 * @property UploadsEntity $uploads
 */
class DocumentFilesEntity extends Entity
{
    public function getFile(): ?File
    {
        return $this->uploads->file();
    }
}
