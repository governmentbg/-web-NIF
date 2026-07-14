<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;
use vakata\files\File;

/**
 * @property int $file
 * @property int $news
 * @property int $pos
 * @property NewsEntity $news_news
 * @property UploadsEntity $uploads
 */
class NewsFilesEntity extends Entity
{
}
