<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $point      The part of the face relative to which the mask should be placed. One of “forehead”, “eyes”, “mouth”, or “chin”.
 * @property float|int $xShift  Shift by X-axis measured in widths of the mask scaled to the face size, from left to right. For example, choosing -1.0 will place mask just to the left of the default mask position.
 * @property float|int $yShift  Shift by Y-axis measured in heights of the mask scaled to the face size, from top to bottom. For example, 1.0 will place the mask just below the default mask position.
 * @property float|int $scale   Mask scaling coefficient. For example, 2.0 means double size.
 *
 * @link https://core.telegram.org/bots/api#maskposition
 */
class MaskPosition extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}