<?php

namespace SKprods\Telegram\Objects\Payments;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property string $title              Product name
 * @property string $description        Product description
 * @property string $startParameter     Unique bot deep-linking parameter that can be used to generate this invoice
 * @property string $currency           Three-letter ISO 4217 currency code
 * @property int $totalAmount           Total price in the smallest units of the currency (integer, not float/double)
 *
 * @link https://core.telegram.org/bots/api#invoice
 */
class Invoice extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}