<?php

namespace SKprods\Telegram\Objects;

/**
 * @property int $messageAutoDeleteTime New auto-delete time for messages in the chat; in seconds
 *
 * @link https://core.telegram.org/bots/api#messageautodeletetimerchanged
 */
class MessageAutoDeleteTimerChanged extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}