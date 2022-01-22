<?php

namespace SKprods\Telegram\Objects\Chat;

use SKprods\Telegram\Objects\BaseObject;
use SKprods\Telegram\Objects\User;

/**
 * @property string $status                 The member's status in the chat: "creator", "administrator", "member", "restricted", "left", "kicked"
 * @property User $user                     Information about the user
 * @property string|null $customTitle       Optional. Creator and administrators only. Custom title for this user
 * @property int|null $untilDate            Optional. Restictred and kicked only. Date when restrictions will be lifted for this user, unix time
 * @property bool $canBeEdited              True, if the bot is allowed to edit administrator privileges of that user
 * @property bool $isAnonymous              True, if the user's presence in the chat is hidden
 * @property bool $canManageChat            True, if the administrator can access the chat event log, chat statistics, message statistics in channels, see channel members, see anonymous administrators in supergroups and ignore slow mode. Implied by any other administrator privilege
 * @property bool $canDeleteMessages        True, if the administrator can delete messages of other users
 * @property bool $canManageVoiceChats      True, if the administrator can manage voice chats
 * @property bool $canRestrictMembers       True, if the administrator can restrict, ban or unban chat members
 * @property bool $canPromoteMembers        True, if the administrator can add new administrators with a subset of their own privileges or demote administrators that he has promoted, directly or indirectly (promoted by administrators that were appointed by the user)
 * @property bool $canChangeInfo            True, if the user is allowed to change the chat title, photo and other settings
 * @property bool $canInviteUsers           True, if the user is allowed to invite new users to the chat
 * @property bool $canPostMessages          True, if the administrator can post in the channel; channels only
 * @property bool $canEditMessages          True, if the administrator can edit messages of other users and can pin messages; channels only
 * @property bool $canPinMessages           True, if the user is allowed to pin messages; groups and supergroups only
 * @property bool $canSendMessages          True, if the user is allowed to send text messages, contacts, locations and venues
 * @property bool $canSendMediaMessages     True, if the user is allowed to send audios, documents, photos, videos, video notes and voice notes
 * @property bool $canSendPolls             True, if the user is allowed to send polls
 * @property bool $canSendOtherMessages     True, if the user is allowed to send animations, games, stickers and use inline bots
 * @property bool $canAddWebPagePreviews    True, if the user is allowed to add web page previews to their messages
 *
 * @link https://core.telegram.org/bots/api#chatmember
 */
class ChatMember extends BaseObject
{
    protected function casts(): array
    {
        return [
            'user' => User::class,
        ];
    }

    protected function defaults(): array
    {
        return [
            'can_be_edited' => false,
            'is_anonymous' => false,
            'can_manage_chat' => false,
            'can_delete_messages' => false,
            'can_manage_voice_chats' => false,
            'can_restrict_members' => false,
            'can_promote_members' => false,
            'can_change_info' => false,
            'can_invite_users' => false,
            'can_post_messages' => false,
            'can_edit_messages' => false,
            'can_pin_messages' => false,
            'can_send_messages' => false,
            'can_send_media_messages' => false,
            'can_send_polls' => false,
            'can_send_other_messages' => false,
            'can_add_web_page_previews' => false,
        ];
    }
}