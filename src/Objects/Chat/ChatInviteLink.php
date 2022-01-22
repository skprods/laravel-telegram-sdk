<?php

namespace SKprods\Telegram\Objects\Chat;

use SKprods\Telegram\Objects\BaseObject;
use SKprods\Telegram\Objects\User;

/**
 * @property string $inviteLink                 The invite link. If the link was created by another chat administrator, then the second part of the link will be replaced with “…”.
 * @property User $creator                      Creator of the link
 * @property bool $createsJoinRequest           True, if users joining the chat via the link need to be approved by chat administrators
 * @property bool $isPrimary                    True, if the link is primary
 * @property bool $isRevoked                    True, if the link is revoked
 * @property string|null $name                  Optional. Invite link name
 * @property int|null $expireDate               Optional. Point in time (Unix timestamp) when the link will expire or has been expired
 * @property int|null $memberLimit              Optional. Maximum number of users that can be members of the chat simultaneously after joining the chat via this invite link; 1-99999
 * @property int|null $pendingJoinRequestCount  Optional. Number of pending join requests created using this link
 *
 * @link https://core.telegram.org/bots/api#chatinvitelink
 */
class ChatInviteLink extends BaseObject
{
    protected function casts(): array
    {
        return [
            'creator' => User::class,
        ];
    }
}