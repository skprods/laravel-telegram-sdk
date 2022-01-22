<?php

namespace SKprods\Telegram\Objects\Payments;

use SKprods\Telegram\Objects\BaseObject;
use SKprods\Telegram\Objects\User;

/**
 * @property string $id                         Unique query identifier
 * @property User $user                         User who sent the query
 * @property string $invoicePayload             Bot specified invoice payload
 * @property ShippingAddress $shippingAddress   User specified shipping address
 *
 * @link https://core.telegram.org/bots/api#shippingquery
 */
class ShippingQuery extends BaseObject
{
    protected function casts(): array
    {
        return [
            'user' => User::class,
            'shipping_address' => ShippingAddress::class,
        ];
    }
}