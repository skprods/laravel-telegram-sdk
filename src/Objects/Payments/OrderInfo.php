<?php

namespace SKprods\Telegram\Objects\Payments;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property string|null $name                      Optional. User name
 * @property string|null $phoneNumber               Optional. User's phone number
 * @property string|null $email                     Optional. User email
 * @property ShippingAddress|null $shippingAddress  Optional. User shipping address
 *
 * @link https://core.telegram.org/bots/api#orderinfo
 */
class OrderInfo extends BaseObject
{
    protected function casts(): array
    {
        return [
            'shipping_address' => ShippingAddress::class,
        ];
    }
}