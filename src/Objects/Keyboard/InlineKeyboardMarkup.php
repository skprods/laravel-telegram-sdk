<?php

namespace SKprods\Telegram\Objects\Keyboard;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property InlineKeyboard $inlineKeyboard Array of button rows, each represented by an Array of InlineKeyboardButton objects
 *
 * @link https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
class InlineKeyboardMarkup extends BaseObject
{
    protected function casts(): array
    {
        return [
            'inline_keyboard' => InlineKeyboard::class
        ];
    }
}