<?php

namespace SKprods\Telegram\Objects\Keyboard;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property ReplyKeyboard $keyboard            Array of button rows, each represented by an Array of KeyboardButton objects
 * @property bool|null $resizeKeyboard          Optional. Requests clients to resize the keyboard vertically for optimal fit
 * @property bool|null $oneTimeKeyboard         Optional. Requests clients to hide the keyboard as soon as it's been used
 * @property string|null $inputFieldPlaceholder Optional. The placeholder to be shown in the input field when the keyboard is active; 1-64 characters
 * @property bool|null $selective               Optional. Use this parameter if you want to show the keyboard to specific users only
 *
 * @link https://core.telegram.org/bots/api#replykeyboardmarkup
 */
class ReplyKeyboardMarkup extends BaseObject
{
    protected function casts(): array
    {
        return [
            'keyboard' => ReplyKeyboard::class,
        ];
    }
}