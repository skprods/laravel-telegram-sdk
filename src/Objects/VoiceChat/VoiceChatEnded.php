<?php

namespace SKprods\Telegram\Objects\VoiceChat;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property int $duration  Voice chat duration in seconds
 *
 * @link https://core.telegram.org/bots/api#voicechatended
 */
class VoiceChatEnded extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}