<?php

namespace SKprods\Telegram\Objects\Payments;

use SKprods\Telegram\Objects\BaseObject;
use SKprods\Telegram\Objects\User;

/**
 * @property string $id                     Unique query identifier
 * @property User $user                     User who sent the query
 * @property string $currency               Three-letter ISO 4217 currency code
 * @property int $totalAmount               Total price in the smallest units of the currency (integer, not float/double)
 * @property string $invoicePayload         Bot specified invoice payload
 * @property string|null $shippingOptionId  Optional. Identifier of the shipping option chosen by the user
 * @property OrderInfo|null $orderInfo      Optional. Order info provided by the user
 *
 * @link https://core.telegram.org/bots/api#precheckoutquery
 */
class PreCheckoutQuery extends BaseObject
{
    protected function casts(): array
    {
        return [
            'user' => User::class,
            'order_info' => OrderInfo::class,
        ];
    }
}