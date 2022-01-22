<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $fileId         Identifier for this file, which can be used to download or reuse the file
 * @property string $fileUniqueId   Unique identifier for this file, which is supposed to be the same over time
 * @property int $duration          Duration of the audio in seconds as defined by sender
 * @property string|null $mimeType  Optional. MIME type of the file as defined by sender
 * @property int|null $fileSize     Optional. File size in bytes
 *
 * @link https://core.telegram.org/bots/api#voice
 */
class Voice extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}