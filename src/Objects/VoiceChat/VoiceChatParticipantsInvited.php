<?php

namespace SKprods\Telegram\Objects\VoiceChat;

use SKprods\Telegram\Objects\BaseObject;
use SKprods\Telegram\Objects\User;

/**
 * @property User[]|null $users Optional. New members that were invited to the voice chat
 *
 * @link https://core.telegram.org/bots/api#voicechatparticipantsinvited
 */
class VoiceChatParticipantsInvited extends BaseObject
{
    protected function casts(): array
    {
        return [
            'users' => User::class,
        ];
    }
}