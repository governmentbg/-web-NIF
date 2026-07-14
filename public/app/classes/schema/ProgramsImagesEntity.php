<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;
use vakata\files\File;

/**
 * @property int $program
 * @property int $image
 * @property int $pos
 * @property ProgramsEntity $programs
 * @property UploadsEntity $uploads
 */
class ProgramsImagesEntity extends Entity
{
    public function file(): ?File
    {
        return $this->uploads->file();
    }
}
