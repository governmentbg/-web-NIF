<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $topic
 * @property int $forum
 * @property string $created
 * @property int $usr
 * @property string $name
 * @property string $content
 * @property int $hidden
 * @property int $locked
 * @property string $updated
 * @property \vakata\collection\Collection<int,ForumTopicFilesEntity> $forum_topic_files
 * @property \vakata\collection\Collection<int,ForumPostsEntity> $forum_posts
 * @property \vakata\collection\Collection<int,UserForumsEntity> $user_forums
 * @property ?ForumsEntity $forums
 * @property ?UsersEntity $users
 */
class ForumTopicsEntity extends Entity
{
}
