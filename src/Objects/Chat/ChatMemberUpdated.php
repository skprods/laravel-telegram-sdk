<?php

namespace SKprods\Telegram\Objects\Chat;

use SKprods\Telegram\Objects\BaseObject;
use SKprods\Telegram\Objects\User;

/**
 * @property Chat $chat                         Chat the user belongs to
 * @property User $from                         Performer of the action, which resulted in the change
 * @property int $date                          Date the change was done in Unix time
 * @property ChatMember $oldChatMember          Previous information about the chat member
 * @property ChatMember $newChatMember          New information about the chat member
 * @property ChatInviteLink|null $inviteLink    Optional. Chat invite link, which was used by the user to join the chat; for joining by invite link events only.
 *
 * @link https://core.telegram.org/bots/api#chatmemberupdated
 */
class ChatMemberUpdated extends BaseObject
{
    protected function casts(): array
    {
        return [
            'chat' => Chat::class,
            'from' => User::class,
            'old_chat_member' => ChatMember::class,
            'new_chat_member' => ChatMember::class,
            'invite_link' => ChatInviteLink::class,
        ];
    }
}