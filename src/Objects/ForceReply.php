<?php

namespace SKprods\Telegram\Objects;

/**
 * @property bool $forceReply                       Shows reply interface to the user, as if they manually selected the bot's message and tapped 'Reply'
 * @property string|null $inputFieldPlaceholder     Optional. The placeholder to be shown in the input field when the reply is active; 1-64 characters
 * @property bool|null $selective                   Optional. Use this parameter if you want to force reply from specific users only
 *
 * @link https://core.telegram.org/bots/api#forcereply
 */
class ForceReply extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}