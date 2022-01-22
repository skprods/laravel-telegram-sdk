<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $id                 Unique identifier for this query
 * @property User $from                 Sender
 * @property string $query              Text of the query (up to 256 characters)
 * @property string $offset             Offset of the results to be returned, can be controlled by the bot
 * @property string|null $chatType      Optional. Type of the chat, from which the inline query was sent
 * @property Location|null $location    Optional. Sender location, only for bots that request user location
 *
 * @link https://core.telegram.org/bots/api#inlinequery
 */
class InlineQuery extends BaseObject
{
    protected function casts(): array
    {
        return [
            'user' => User::class,
            'location' => Location::class,
        ];
    }
}