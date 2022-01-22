<?php

namespace SKprods\Telegram\Objects\Chat;

use SKprods\Telegram\Objects\BaseObject;
use SKprods\Telegram\Objects\User;

/**
 * @property Chat $chat                         Chat to which the request was sent
 * @property User $user                         User that sent the join request
 * @property int $date                          Date the request was sent in Unix time
 * @property string|null $bio                   Optional. Bio of the user
 * @property ChatInviteLink|null $inviteLink    Optional. Chat invite link that was used by the user to send the join request
 *
 * @link https://core.telegram.org/bots/api#chatjoinrequest
 */
class ChatJoinRequest extends BaseObject
{
    protected function casts(): array
    {
        return [
            'chat' => Chat::class,
            'from' => User::class,
            'invite_link' => ChatInviteLink::class,
        ];
    }
}