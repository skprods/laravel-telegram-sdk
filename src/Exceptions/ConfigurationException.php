<?php

namespace SKprods\Telegram\Exceptions;

use Exception;
use Throwable;

class ConfigurationException extends Exception
{
    public static function redisConnection(string $connection): self
    {
        return new static("Не удалось найти настройки для подключения к Redis [$connection]");
    }

    public static function emptyRedisConnectionName(): self
    {
        $message = 'В конфигурации не указано название соединения к Redis. ';
        $message .= 'Убедитесь, что оно указано в config/telegram.php в секции chatInfo';

        return new static($message);
    }

    public static function emptyCustomHandler(): self
    {
        $message = 'В конфигурации не указан класс-обработчик ChatInfo. ';
        $message .= 'Убедитесь, что он указан в config/telegram.php в секции chatInfo';

        return new static($message);
    }
}