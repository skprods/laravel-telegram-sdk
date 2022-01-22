<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $fileId                     Identifier for this file, which can be used to download or reuse the file
 * @property string $fileUniqueId               Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int $width                         Video width as defined by sender
 * @property int $height                        Video height as defined by sender
 * @property bool $isAnimated                   True, if the sticker is animated
 * @property PhotoSize|null $thumb              Optional. Thumbnail of the album cover to which the music file belongs
 * @property string|null $emoji                 Optional. Emoji associated with the sticker
 * @property string|null $setName               Optional. Name of the sticker set to which the sticker belongs
 * @property MaskPosition|null $maskPosition    Optional. For mask stickers, the position where the mask should be placed
 * @property int|null $fileSize                 Optional. File size in bytes
 *
 * @link https://core.telegram.org/bots/api#sticker
 */
class Sticker extends BaseObject
{
    protected function casts(): array
    {
        return [
            'thumb' => PhotoSize::class,
            'mask_position' => MaskPosition::class,
        ];
    }
}