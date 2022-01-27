<?php

namespace SKprods\Telegram\Objects;

use SKprods\Telegram\Objects\Keyboard\InlineKeyboardMarkup;
use SKprods\Telegram\Objects\Passport\PassportData;
use SKprods\Telegram\Objects\Chat\Chat;
use SKprods\Telegram\Objects\Payments\Invoice;
use SKprods\Telegram\Objects\Payments\SuccessfulPayment;
use SKprods\Telegram\Objects\VoiceChat\VoiceChatStarted;
use SKprods\Telegram\Objects\VoiceChat\VoiceChatEnded;
use SKprods\Telegram\Objects\VoiceChat\VoiceChatParticipantsInvited;
use SKprods\Telegram\Objects\VoiceChat\VoiceChatScheduled;

/**
 * @property int $messageId                         Unique message identifier inside this chat
 * @property User|null $from                        Optional. Sender of the message; empty for messages sent to channels.
 * @property Chat|null $senderChat                  Optional. Sender of the message, sent on behalf of a chat.
 * @property int $date                              Date the message was sent in Unix time
 * @property Chat $chat                             Conversation the message belongs to
 * @property User|null $forwardFrom                 Optional. For forwarded messages, sender of the original message
 * @property Chat|null $forwardFromChat             Optional. For messages forwarded from channels or from anonymous administrators, information about the original sender chat
 * @property int|null $forwardFromMessageId         Optional. For messages forwarded from channels, identifier of the original message in the channel
 * @property string|null $forwardSignature          Optional. For forwarded messages that were originally sent in channels or by an anonymous chat administrator, signature of the message sender if present
 * @property string|null $forwardSenderName         Optional. Sender's name for messages forwarded from users who disallow adding a link to their account in forwarded messages
 * @property int|null $forwardDate                  Optional. For forwarded messages, date the original message was sent in Unix time
 * @property bool|null $isAutomaticForward          Optional. True, if the message is a channel post that was automatically forwarded to the connected discussion group
 * @property Message|null $replyToMessage           Optional. For replies, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
 * @property User|null $viaBot                      Optional. Bot through which the message was sent
 * @property int|null $editDate                     Optional. Date the message was last edited in Unix time
 * @property bool|null $hasProtectedContent         Optional. True, if the message can't be forwarded
 * @property string|null $mediaGroupId              Optional. The unique identifier of a media message group this message belongs to
 * @property string|null $authorSignature           Optional. Signature of the post author for messages in channels, or the custom title of an anonymous group administrator
 * @property string|null $text                      Optional. For text messages, the actual UTF-8 text of the message, 0-4096 characters
 * @property MessageEntity[]|null $entities         Optional. For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text
 * @property Animation|null $animation              Optional. Message is an animation, information about the animation. For backward compatibility, when this field is set, the document field will also be set
 * @property Audio|null $audio                      Optional. Message is an audio file, information about the file
 * @property Document|null $document                Optional. Message is a general file, information about the file
 * @property PhotoSize[]|null $photo                Optional. Message is a photo, available sizes of the photo
 * @property Sticker|null $sticker                  Optional. Message is a sticker, information about the sticker
 * @property Video|null $video                      Optional. Message is a video, information about the video
 * @property VideoNote|null $videoNote              Optional. Message is a video note, information about the video message
 * @property Voice|null $voice                      Optional. Message is a voice message, information about the file
 * @property string|null $caption                   Optional. Caption for the animation, audio, document, photo, video or voice, 0-1024 characters
 * @property MessageEntity[]|null $captionEntity    Optional. For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption
 * @property Contact|null $contact                  Optional. Message is a shared contact, information about the contact
 * @property Dice|null $dice                        Optional. Message is a dice with random value
 * @property Game|null $game                        Optional. Message is a game, information about the game
 * @property Poll|null $poll                        Optional. Message is a native poll, information about the poll
 * @property Venue|null $venue                      Optional. Message is a venue, information about the venue
 * @property Location|null $location                Optional. Message is a shared location, information about the location
 * @property User[]|null $newChatMembers            Optional. New members that were added to the group or supergroup and information about them (the bot itself may be one of these members)
 * @property User|null $leftChatMember              Optional. A member was removed from the group, information about them (this member may be the bot itself)
 * @property string|null $newChatTitle              Optional. A chat title was changed to this value
 * @property PhotoSize[]|null $newChatPhoto         Optional. A chat photo was change to this value
 * @property bool|null $deleteChatPhoto             Optional. Service message: the chat photo was deleted
 * @property bool|null $groupChatCreated            Optional. Service message: the group has been created
 * @property bool|null $supergroupChatCreated       Optional. Service message: the supergroup has been created
 * @property bool|null $channelChatCreated          Optional. Service message: the channel has been created
 * @property MessageAutoDeleteTimerChanged|null $messageAutoDeleteTimerChanged  Optional. Service message: auto-delete timer settings changed in the chat
 * @property int|null $migrateToChatId              Optional. The group has been migrated to a supergroup with the specified identifier
 * @property int|null $migrateFromChatId            Optional. The supergroup has been migrated from a group with the specified identifier
 * @property Message|null $pinnedMessage            Optional. Specified message was pinned
 * @property Invoice|null $invoice                  Optional. Message is an invoice for a payment, information about the invoice
 * @property SuccessfulPayment|null $successfulPayment  Optional. Message is a service message about a successful payment, information about the payment
 * @property string|null connectedWebsite           Optional. The domain name of the website on which the user has logged in
 * @property PassportData|null $passportData        Optional. Telegram Passport data
 * @property ProximityAlertTriggered|null $proximityAlertTriggered  Optional. Service message. A user in the chat triggered another user's proximity alert while sharing Live Location
 * @property VoiceChatScheduled|null $voiceChatScheduled  Optional. Service message: voice chat scheduled
 * @property VoiceChatStarted|null $voiceChatStarted  Optional. Service message: voice chat started
 * @property VoiceChatEnded|null $voiceChatEnded    Optional. Service message: voice chat ended
 * @property VoiceChatParticipantsInvited|null $voiceChatParticipantsInvited  Optional. Service message: new participants invited to a voice chat
 * @property InlineKeyboardMarkup|null $replyMarkup Optional. Inline keyboard attached to the message. login_url buttons are represented as ordinary url buttons
 *
 * @link https://core.telegram.org/bots/api#message
 */
class Message extends BaseObject
{
    protected function casts(): array
    {
        return [
            'from' => User::class,
            'sender_chat' => Chat::class,
            'chat' => Chat::class,
            'forward_from' => User::class,
            'forward_from_chat' => Chat::class,
            'reply_to_message' => Message::class,
            'via_bot' => User::class,
            'entities' => [ MessageEntity::class ],
            'animation' => Animation::class,
            'audio' => Audio::class,
            'document' => Document::class,
            'photo' => PhotoSize::class,
            'sticker' => Sticker::class,
            'video' => Video::class,
            'video_note' => VideoNote::class,
            'caption_entities' => [ MessageEntity::class ],
            'contact' => Contact::class,
            'dice' => Dice::class,
            'game' => Game::class,
            'poll' => Poll::class,
            'venue' => Venue::class,
            'location' => Location::class,
            'new_chat_members' => User::class,
            'left_chat_member' => User::class,
            'new_chat_photo' => [ PhotoSize::class ],
            'message_auto_delete_timer_changed',
            'pinned_message' => Message::class,
            'invoice' => Invoice::class,
            'successful_payment' => SuccessfulPayment::class,
            'passport_data' => PassportData::class,
            'proximity_alert_triggered' => ProximityAlertTriggered::class,
            'voice_chat_scheduled' => VoiceChatScheduled::class,
            'voice_chat_started' => VoiceChatStarted::class,
            'voice_chat_ended' => VoiceChatEnded::class,
            'voice_chat_participants_invited' => VoiceChatParticipantsInvited::class,
            'reply_markup' => InlineKeyboardMarkup::class,
        ];
    }
}