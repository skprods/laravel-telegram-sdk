<?php

namespace SKprods\Telegram\Objects\Keyboard;

use SKprods\Telegram\Objects\BaseObject;
use SKprods\Telegram\Objects\CallbackGame;
use SKprods\Telegram\Objects\LoginUrl;

/**
 * @property string $text                               Label text on the button
 * @property string|null $url                           Optional. HTTP or tg:// url to be opened when the button is pressed. Links tg://user?id=<user_id> can be used to mention a user by their ID without using a username, if this is allowed by their privacy settings.
 * @property LoginUrl|null $loginUrl                    Optional. An HTTP URL used to automatically authorize the user. Can be used as a replacement for the Telegram Login Widget.
 * @property string|null $callbackData                  Optional. Data to be sent in a callback query to the bot when button is pressed, 1-64 bytes
 * @property string|null $switchInlineQuery             Optional. If set, pressing the button will prompt the user to select one of their chats, open that chat and insert the bot's username and the specified inline query in the input field
 * @property string|null $switchInlineQueryCurrentChat  Optional. If set, pressing the button will insert the bot's username and the specified inline query in the current chat's input field
 * @property CallbackGame|null $callbackGame            Optional. Description of the game that will be launched when the user presses the button.
 * @property bool|null $pay                             Optional. Specify True, to send a Pay button.
 *
 * @link https://core.telegram.org/bots/api#inlinekeyboardbutton
 */
class InlineKeyboardButton extends BaseObject
{
    protected function casts(): array
    {
        return [
            'login_url' => LoginUrl::class,
            'callback_game' => CallbackGame::class,
        ];
    }
}