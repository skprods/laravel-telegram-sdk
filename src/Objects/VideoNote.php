<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $fileId         Identifier for this file, which can be used to download or reuse the file
 * @property string $fileUniqueId   Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int $length            Video width and height (diameter of the video message) as defined by sender
 * @property int $duration          Duration of the audio in seconds as defined by sender
 * @property PhotoSize|null $thumb  Optional. Thumbnail of the album cover to which the music file belongs
 * @property int|null $fileSize     Optional. File size in bytes
 *
 * @link https://core.telegram.org/bots/api#videonote
 */
class VideoNote extends BaseObject
{
    protected function casts(): array
    {
        return [
            'thumb' => PhotoSize::class,
        ];
    }
}