<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $title                      Title of the game
 * @property string $description                Description of the game
 * @property PhotoSize[] $photo                 Photo that will be displayed in the game message in chats.
 * @property string|null $text                  Optional. Brief description of the game or high scores included in the game message.
 * @property MessageEntity[]|null $textEntities Optional. Special entities that appear in text, such as usernames, URLs, bot commands, etc.
 * @property Animation|null $animation          Optional. Animation that will be displayed in the game message in chats. Upload via BotFather
 *
 * @link https://core.telegram.org/bots/api#game
 */
class Game extends BaseObject
{
    protected function casts(): array
    {
        return [
            'photo' => PhotoSize::class,
            'text_entities' => MessageEntity::class,
            'animation' => Animation::class,
        ];
    }
}