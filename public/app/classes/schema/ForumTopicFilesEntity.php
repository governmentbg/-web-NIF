<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $topic
 * @property int $upload
 * @property int $pos
 * @property ?ForumTopicsEntity $forum_topics
 * @property ?UploadsEntity $uploads
 */
class ForumTopicFilesEntity extends Entity
{
}
