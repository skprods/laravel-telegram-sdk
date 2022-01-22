<?php

namespace SKprods\Telegram\Objects\Keyboard;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property bool $removeKeyboard   Requests clients to remove the custom keyboard (user will not be able to summon this keyboard; if you want to hide the keyboard from sight but keep it accessible, use one_time_keyboard in ReplyKeyboardMarkup)
 * @property bool|null $selective   Optional. Use this parameter if you want to remove the keyboard for specific users only
 *
 * @link https://core.telegram.org/bots/api#replykeyboardremove
 */
class ReplyKeyboardRemove extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}