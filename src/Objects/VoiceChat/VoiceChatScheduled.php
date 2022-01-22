<?php

namespace SKprods\Telegram\Objects\VoiceChat;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property int $startDate Point in time (Unix timestamp) when the voice chat is supposed to be started by a chat administrator
 *
 * @link https://core.telegram.org/bots/api#voicechatscheduled
 */
class VoiceChatScheduled extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}