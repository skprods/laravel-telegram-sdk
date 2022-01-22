<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $url                    An HTTP URL to be opened with user authorization data added to the query string when the button is pressed
 * @property string|null $forwardText       Optional. New text of the button in forwarded messages
 * @property string|null $botUsername       Optional. Username of a bot, which will be used for user authorization
 * @property bool|null $requestWriteAccess  Optional. Pass True to request the permission for your bot to send messages to the user.
 *
 * @link https://core.telegram.org/bots/api#loginurl
 */
class LoginUrl extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}