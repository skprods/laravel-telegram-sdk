<?php

namespace SKprods\Telegram\Objects\Chat;

use SKprods\Telegram\Objects\BaseObject;
use SKprods\Telegram\Objects\Location;

/**
 * @property Location $location The location to which the supergroup is connected. Can't be a live location.
 * @property string $address    Location address; 1-64 characters, as defined by the chat owner
 *
 * @link https://core.telegram.org/bots/api#chatlocation
 */
class ChatLocation extends BaseObject
{
    protected function casts(): array
    {
        return [
            'location' => Location::class,
        ];
    }
}