<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $resultId               The unique identifier for the result that was chosen
 * @property User $user                     The user that chose the result
 * @property Location|null $location        Optional. Sender location, only for bots that require user location
 * @property string|null $inlineMessageId   Optional. Identifier of the sent inline message
 * @property string $query                  The query that was used to obtain the result
 *
 * @link https://core.telegram.org/bots/api#choseninlineresult
 */
class ChosenInlineResult extends BaseObject
{
    protected function casts(): array
    {
        return [
            'from' => User::class,
            'location' => Location::class,
        ];
    }
}