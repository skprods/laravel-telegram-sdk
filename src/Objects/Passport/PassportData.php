<?php

namespace SKprods\Telegram\Objects\Passport;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property EncryptedPassportElement[] $data   Array with information about documents and other Telegram Passport elements that was shared with the bot
 * @property EncryptedCredentials $credentials  Encrypted credentials required to decrypt the data
 *
 * @link https://core.telegram.org/bots/api#passportdata
 */
class PassportData extends BaseObject
{
    protected function casts(): array
    {
        return [
            'data' => EncryptedPassportElement::class,
            'credentials' => EncryptedCredentials::class,
        ];
    }
}