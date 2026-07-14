<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;
use vakata\files\File;

/**
 * @property int $program
 * @property int $pos
 * @property int $file
 * @property ProgramsEntity $programs
 * @property UploadsEntity $uploads
 */
class ProgramsFilesEntity extends Entity
{
}
