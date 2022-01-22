<?php

namespace SKprods\Telegram\Objects\Keyboard;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property string $text                               Text of the button. If none of the optional fields are used, it will be sent as a message when the button is pressed
 * @property bool|null $requestContact                  Optional. If True, the user's phone number will be sent as a contact when the button is pressed. Available in private chats only
 * @property bool|null $requestLocation                 Optional. If True, the user's current location will be sent when the button is pressed. Available in private chats only
 * @property KeyboardButtonPollType|null $requestPoll   Optional. If specified, the user will be asked to create a poll and send it to the bot when the button is pressed. Available in private chats only
 *
 * @link https://core.telegram.org/bots/api#keyboardbutton
 */
class KeyboardButton extends BaseObject
{
    protected function casts(): array
    {
        return [
            'request_poll' => KeyboardButtonPollType::class,
        ];
    }
}