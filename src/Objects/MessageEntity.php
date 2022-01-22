<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $type       Type of the entity. Examples in @link
 * @property int $offset        Offset in UTF-16 code units to the start of the entity
 * @property int $length        Length of the entity in UTF-16 code units
 * @property string|null $url   Optional. For “text_link” only, url that will be opened after user taps on the text
 * @property User|null $user    Optional. For “text_mention” only, the mentioned user
 * @property string $language   Optional. For “pre” only, the programming language of the entity text
 *
 * @link https://core.telegram.org/bots/api#messageentity
 */
class MessageEntity extends BaseObject
{
    protected function casts(): array
    {
        return [
            'user' => User::class,
        ];
    }
}