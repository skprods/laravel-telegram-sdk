<?php

namespace SKprods\Telegram\Exceptions;

use Exception;

class TelegramException extends Exception
{
    public static function tokenNotProvided($tokenEnvName): self
    {
        return new static('Required "token" not supplied in config and could not find fallback environment variable ' . $tokenEnvName . '');
    }
}