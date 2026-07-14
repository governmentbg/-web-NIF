<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;
use vakata\files\File;

/**
 * @property int $program
 * @property int $pos
 * @property int $file
 * @property UploadsEntity $uploads
 * @property ProgramsEntity $programs
 */
class ProgramsFilesEntity extends Entity
{
    public function getFile(): ?File
    {
        return $this->uploads->file();
    }
}
