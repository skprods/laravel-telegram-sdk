<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $text       Option text, 1-100 characters
 * @property int $voterCount    Number of users that voted for this option
 *
 * @link https://core.telegram.org/bots/api#polloption
 */
class PollOption extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}