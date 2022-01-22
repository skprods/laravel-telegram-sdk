<?php

namespace SKprods\Telegram\Objects\Passport;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property string $fileId         Identifier for this file, which can be used to download or reuse the file
 * @property string $fileUniqueId   Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file
 * @property int $fileSize          File size in bytes
 * @property int $fileData          Unix time when the file was uploaded
 *
 * @link https://core.telegram.org/bots/api#passportfile
 */
class PassportFile extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}