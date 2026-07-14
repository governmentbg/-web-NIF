<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $post
 * @property int $topic
 * @property string $created
 * @property int $usr
 * @property ?string $content
 * @property int $hidden
 * @property \vakata\collection\Collection<int,ForumPostFilesEntity> $forum_post_files
 * @property ?ForumTopicsEntity $forum_topics
 * @property ?UsersEntity $users
 */
class ForumPostsEntity extends Entity
{
}
