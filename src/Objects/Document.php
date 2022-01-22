<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $fileId         Identifier for this file, which can be used to download or reuse the file
 * @property string $fileUniqueId   Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property PhotoSize|null $thumb  Optional. Thumbnail of the album cover to which the music file belongs
 * @property string|null $fileName  Optional. Original filename as defined by sender
 * @property string|null $mimeType  Optional. MIME type of the file as defined by sender
 * @property int|null $fileSize     Optional. File size in bytes
 *
 * @link https://core.telegram.org/bots/api#document
 */
class Document extends BaseObject
{
    protected function casts(): array
    {
        return [
            'thumb' => PhotoSize::class,
        ];
    }
}