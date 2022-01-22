<?php

namespace SKprods\Telegram\Objects\Keyboard;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property string|null $type  Optional. If quiz is passed, the user will be allowed to create only polls in the quiz mode. If regular is passed, only regular polls will be allowed. Otherwise, the user will be allowed to create a poll of any type
 *
 * @link https://core.telegram.org/bots/api#keyboardbuttonpolltype
 */
class KeyboardButtonPollType extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}