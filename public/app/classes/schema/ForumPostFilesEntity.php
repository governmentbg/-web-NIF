<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $post
 * @property int $upload
 * @property int $pos
 * @property ?ForumPostsEntity $forum_posts
 * @property ?UploadsEntity $uploads
 */
class ForumPostFilesEntity extends Entity
{
}
