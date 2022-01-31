<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $name           Sticker set name
 * @property string $title          Sticker set title
 * @property bool $isAnimated       True, if the sticker set contains animated stickers
 * @property bool $containsMasks    True, if the sticker set contains masks
 * @property Sticker[] $stickers    List of all set stickers
 * @property PhotoSize|null $thumb  Optional. Thumbnail of the album cover to which the music file belongs
 *
 * @link https://core.telegram.org/bots/api#stickerset
 */
class StickerSet extends BaseObject
{
    protected function casts(): array
    {
        return [
            'stickers' => Sticker::class,
            'thumb' => PhotoSize::class
        ];
    }
}