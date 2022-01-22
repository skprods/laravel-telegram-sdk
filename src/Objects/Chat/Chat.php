<?php

namespace SKprods\Telegram\Objects\Chat;

use SKprods\Telegram\Objects\BaseObject;
use SKprods\Telegram\Objects\Message;

/**
 * @property int $id                            Unique identifier for this chat
 * @property string $type                       Type of chat, can be either “private”, “group”, “supergroup” or “channel”
 * @property string|null $title                 Optional. Title, for supergroups, channels and group chats
 * @property string|null $username              Optional. Username, for private chats, supergroups and channels if available
 * @property string|null $firstName             Optional. First name of the other party in a private chat
 * @property string|null $lastName              Optional. Last name of the other party in a private chat
 * @property ChatPhoto|null $photo              Optional. Chat photo. Returned only in getChat
 * @property string|null $bio                   Optional. Bio of the other party in a private chat. Returned only in getChat
 * @property bool|null $hasPrivateForwards      Optional. True, if privacy settings of the other party in the private chat allows to use tg://user?id=<user_id> links only in chats with the user. Returned only in getChat.
 * @property string|null $description           Optional. Description, for groups, supergroups and channel chats. Returned only in getChat.
 * @property string|null $inviteLink            Optional. Primary invite link, for groups, supergroups and channel chats. Returned only in getChat.
 * @property Message|null $pinnedMessage        Optional. The most recent pinned message (by sending date). Returned only in getChat.
 * @property ChatPermissions|null $permissions  Optional. Default chat member permissions, for groups and supergroups. Returned only in getChat.
 * @property int|null $slowModeDelay            Optional. For supergroups, the minimum allowed delay between consecutive messages sent by each unpriviledged user; in seconds. Returned only in getChat.
 * @property int|null $messageAutoDeleteTime    Optional. The time after which all messages sent to the chat will be automatically deleted; in seconds. Returned only in getChat.
 * @property bool|null $hasProtectedContent     Optional. True, if messages from the chat can't be forwarded to other chats. Returned only in getChat.
 * @property string|null $stickerSetName        Optional. For supergroups, name of group sticker set. Returned only in getChat.
 * @property bool|null $canSetStickerSet        Optional. True, if the bot can change the group sticker set. Returned only in getChat.
 * @property int|null $linkedChatId             Optional. Unique identifier for the linked chat, i.e. the discussion group identifier for a channel and vice versa; for supergroups and channel chats.
 * @property ChatLocation|null $location        Optional. For supergroups, the location to which the supergroup is connected. Returned only in getChat.
 *
 * @link https://core.telegram.org/bots/api#chat
 */
class Chat extends BaseObject
{
    protected function casts(): array
    {
        return [
            'photo' => ChatPhoto::class,
            'pinned_message' => Message::class,
            'permissions' => ChatPermissions::class,
            'location' => ChatLocation::class,
        ];
    }
}