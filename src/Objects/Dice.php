<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $emoji  Emoji on which the dice throw animation is based
 * @property int $value     Value of the dice, 1-6 for “🎲”, “🎯” and “🎳” base emoji, 1-5 for “🏀” and “⚽” base emoji, 1-64 for “🎰” base emoji
 *
 * @link https://core.telegram.org/bots/api#dice
 */
class Dice extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}