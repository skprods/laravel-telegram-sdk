<?php

namespace SKprods\Telegram\Objects;

/**
 * @property User $traveler User that triggered the alert
 * @property User $watcher  User that set the alert
 * @property int $distance  The distance between the users
 *
 * @link https://core.telegram.org/bots/api#proximityalerttriggered
 */
class ProximityAlertTriggered extends BaseObject
{
    protected function casts(): array
    {
        return [
            'traveler' => User::class,
            'watcher' => User::class,
        ];
    }
}