<?php

namespace SKprods\Telegram\Objects;

/**
 * @property int $position  Позиция в таблице очков
 * @property User $user     Пользователь
 * @property int $score     Очки
 *
 * @link https://core.telegram.org/bots/api#gamehighscore
 */
class GameHighScore extends BaseObject
{
    protected function casts(): array
    {
        return [
            'user' => User::class,
        ];
    }
}