<?php

declare(strict_types=1);

namespace schema;

use vakata\files\File;
use vakata\database\schema\Entity;

/**
 * @property int $file
 * @property int $document
 * @property int $pos
 * @property DocumentsEntity $documents
 * @property UploadsEntity $uploads
 */
class DocumentFilesEntity extends Entity
{
    public function file(): File
    {
        return $this->uploads->file();
    }
}
