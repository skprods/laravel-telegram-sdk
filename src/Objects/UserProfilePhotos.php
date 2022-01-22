<?php

namespace SKprods\Telegram\Objects;

/**
 * @property int $totalCount        Total number of profile pictures the target user has
 * @property PhotoSize[] $photos    Requested profile pictures (in up to 4 sizes each)
 *
 * @link https://core.telegram.org/bots/api#userprofilephotos
 */
class UserProfilePhotos extends BaseObject
{
    protected function casts(): array
    {
        return [
            'photos' => PhotoSize::class,
        ];
    }
}