<?php

namespace SKprods\Telegram\Core;

use SKprods\Telegram\Exceptions\TelegramException;

class Telegram
{
    const BOT_TOKEN_ENV_NAME = 'TELEGRAM_BOT_TOKEN';

    /** @var string The Telegram Bot API Access Token */
    private string $accessToken;

    /**
     * Instantiates a new Telegram class object
     *
     * @throws TelegramException
     */
    public function __construct(string $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * @throws TelegramException
     */
    private function setAccessToken(string $accessToken)
    {
        $token = $accessToken ?? getenv(static::BOT_TOKEN_ENV_NAME);

        if (!$token || !is_string($token)) {
            throw TelegramException::tokenNotProvided(static::BOT_TOKEN_ENV_NAME);
        }

        $this->accessToken = $token;
    }
}