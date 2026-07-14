<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $notification
 * @property int $upload
 * @property int $pos
 * @property NotificationsEntity $notifications
 * @property UploadsEntity $uploads
 */
class NotificationFilesEntity extends Entity
{
}
