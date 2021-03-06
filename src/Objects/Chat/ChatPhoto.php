<?php

namespace SKprods\Telegram\Objects\Chat;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property string $smallFileId        File identifier of small (160x160) chat photo. This file_id can be used only for photo download and only for as long as the photo is not changed.
 * @property string $smallFileUniqueId  Unique file identifier of small (160x160) chat photo, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property string $bigFileId          File identifier of big (640x640) chat photo. This file_id can be used only for photo download and only for as long as the photo is not changed.
 * @property string $bigFileUniqueId    Unique file identifier of big (640x640) chat photo, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 *
 * @link https://core.telegram.org/bots/api#chatphoto
 */
class ChatPhoto extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}