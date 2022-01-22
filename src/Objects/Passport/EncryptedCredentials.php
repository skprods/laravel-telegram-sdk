<?php

namespace SKprods\Telegram\Objects\Passport;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property string $data   Base64-encoded encrypted JSON-serialized data with unique user's payload, data hashes and secrets required for EncryptedPassportElement decryption and authentication
 * @property string $hash   Base64-encoded data hash for data authentication
 * @property string $secret Base64-encoded secret, encrypted with the bot's public RSA key, required for data decryption
 *
 * @link https://core.telegram.org/bots/api#encryptedcredentials
 */
class EncryptedCredentials extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}