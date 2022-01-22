<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $command        Text of the command; 1-32 characters. Can contain only lowercase English letters, digits and underscores
 * @property string $description    Description of the command; 1-256 characters.
 *
 * @link https://core.telegram.org/bots/api#botcommand
 */
class BotCommand extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}