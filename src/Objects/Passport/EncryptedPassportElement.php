<?php

namespace SKprods\Telegram\Objects\Passport;

use SKprods\Telegram\Objects\BaseObject;

/**
 * @property string $type                       Element type
 * @property string|null $data                  Optional. Base64-encoded encrypted Telegram Passport element data provided by the user
 * @property string|null $phoneNumber           Optional. User's verified phone number, available only for “phone_number” type
 * @property string|null $email                 Optional. User's verified email address, available only for “email” type
 * @property PassportFile[]|null $files         Optional. Array of encrypted files with documents provided by the user, available for “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration” types. Files can be decrypted and verified using the accompanying EncryptedCredentials.
 * @property PassportFile|null $frontSide       Optional. Encrypted file with the front side of the document, provided by the user. Available for “passport”, “driver_license”, “identity_card” and “internal_passport”. The file can be decrypted and verified using the accompanying EncryptedCredentials.
 * @property PassportFile|null $reverseSide     Optional. Encrypted file with the reverse side of the document, provided by the user. Available for “driver_license” and “identity_card”. The file can be decrypted and verified using the accompanying EncryptedCredentials.
 * @property PassportFile|null $selfie          Optional. Encrypted file with the selfie of the user holding a document, provided by the user; available for “passport”, “driver_license”, “identity_card” and “internal_passport”. The file can be decrypted and verified using the accompanying EncryptedCredentials.
 * @property PassportFile[]|null $translation   Optional. Array of encrypted files with translated versions of documents provided by the user
 * @property string $hash                       Base64-encoded element hash for using in PassportElementErrorUnspecified
 *
 * @link https://core.telegram.org/bots/api#encryptedpassportelement
 */
class EncryptedPassportElement extends BaseObject
{
    protected function casts(): array
    {
        return [
            'files' => [ PassportFile::class ],
            'front_side' => PassportFile::class,
            'reverse_side' => PassportFile::class,
            'selfie' => PassportFile::class,
            'translation' => [ PassportFile::class ],
        ];
    }
}