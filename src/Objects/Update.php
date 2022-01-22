<?php

namespace SKprods\Telegram\Objects;

use SKprods\Telegram\Objects\Chat\ChatJoinRequest;
use SKprods\Telegram\Objects\Chat\ChatMemberUpdated;
use SKprods\Telegram\Objects\Payments\PreCheckoutQuery;
use SKprods\Telegram\Objects\Payments\ShippingQuery;

/**
 * @property int $updateId                                  The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially
 * @property Message|null $message                          Optional. New incoming message of any kind — text, photo, sticker, etc
 * @property Message|null $editedMessage                    Optional. New version of a message that is known to the bot and was edited
 * @property Message|null $channelPost                      Optional. New incoming channel post of any kind — text, photo, sticker, etc
 * @property Message|null $editedChannelPost                Optional. New version of a channel post that is known to the bot and was edited
 * @property InlineQuery|null $inlineQuery                  Optional. New incoming inline query
 * @property ChosenInlineResult|null $chosenInlineResult    Optional. The result of an inline query that was chosen by a user and sent to their chat partner
 * @property CallbackQuery|null $callbackQuery              Optional. New incoming callback query
 * @property ShippingQuery|null $shippingQuery              Optional. New incoming shipping query
 * @property PreCheckoutQuery|null $preCheckoutQuery        Optional. New incoming pre-checkout query
 * @property Poll|null $poll                                Optional. New poll state
 * @property PollAnswer|null $pollAnswer                    Optional. A user changed their answer in a non-anonymous poll
 * @property ChatMemberUpdated|null $myChatMember           Optional. The bot's chat member status was updated in a chat
 * @property ChatMemberUpdated|null $chatMember             Optional. A chat member's status was updated in a chat
 * @property ChatJoinRequest|null $chatJoinRequest          Optional. A request to join the chat has been sent.
 *
 * @link https://core.telegram.org/bots/api#update
 */
class Update extends BaseObject
{
    protected function casts(): array
    {
        return [
            'message' => Message::class,
            'edited_message' => Message::class,
            'channel_post' => Message::class,
            'edited_channel_post' => Message::class,
            'inline_query' => InlineQuery::class,
            'chosen_inline_result' => ChosenInlineResult::class,
            'callback_query' => CallbackQuery::class,
            'shipping_query' => ShippingQuery::class,
            'pre_checkout_query' => PreCheckoutQuery::class,
            'poll' => Poll::class,
            'poll_answer' => PollAnswer::class,
            'my_chat_member' => ChatMemberUpdated::class,
            'chat_member' => ChatMemberUpdated::class,
            'chat_join_request' => ChatJoinRequest::class,
        ];
    }
}