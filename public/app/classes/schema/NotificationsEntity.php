<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $notification
 * @property ?int $thread
 * @property ?int $sender
 * @property string $title
 * @property string $body
 * @property string $link
 * @property string $sent
 * @property int $reply
 * @property ?UsersEntity $users
 * @property ?NotificationsEntity $thread_notifications
 * @property \vakata\collection\Collection<int,NotificationsEntity> $notifications_thread
 * @property \vakata\collection\Collection<int,NotificationFilesEntity> $notification_files
 * @property \vakata\collection\Collection<int,NotificationRecipientsEntity> $notification_recipients
 */
class NotificationsEntity extends Entity
{
}
