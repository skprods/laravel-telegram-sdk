<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $fileId         Identifier for this file, which can be used to download or reuse the file
 * @property string $fileUniqueId   Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int $width             Photo width
 * @property int $height            Photo height
 * @property int|null $fileSize     Optional. File size in bytes
 *
 * @link https://core.telegram.org/bots/api#photosize
 */
class PhotoSize extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}