<?php

namespace SKprods\Telegram\Core;

use SKprods\Telegram\Exceptions\TelegramException;

class Config
{
    public function __construct(
        public string $name,
        public string $token,
        public string|null $webhookUrl = null,
        public bool $allowDialog = true,
        public array $commands = [],
        public array $dialogs = [],
        public array $allowedChats = [],
        public array $allowedUsers = [],
        public FreeHandler|null $freeHandler = null
    ) {
    }

    /** @throws TelegramException */
    public static function make(string $name, array $config): self
    {
        if (!$config['token']) {
            throw TelegramException::tokenNotProvided($name);
        }

        return new self(
            $name,
            $config['token'],
            $config['webhook_url'] ?? null,
            $config['allow_dialog'] ?? true,
            $config['commands'] ?? [],
            $config['dialogs'] ?? [],
            $config['allowed_chats'] ?? [],
            $config['allowed_users'] ?? [],
            $config['freeHandler'] ?? null
        );
    }
}
