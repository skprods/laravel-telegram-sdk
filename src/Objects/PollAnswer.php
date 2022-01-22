<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $pollId     Unique poll identifier
 * @property User $user         The user, who changed the answer to the poll
 * @property array $optionIds   0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.
 *
 * @link https://core.telegram.org/bots/api#pollanswer
 */
class PollAnswer extends BaseObject
{
    protected function casts(): array
    {
        return [
            'user' => User::class,
        ];
    }
}