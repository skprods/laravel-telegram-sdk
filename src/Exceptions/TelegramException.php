<?php

namespace SKprods\Telegram\Exceptions;

use Exception;
use Throwable;

class TelegramException extends Exception
{
    public static function tokenNotProvided(string $botName): self
    {
        return new static("Обязательный параметр 'token' не найден в конфигурации бота '$botName'");
    }

    public static function badMethodCall(string $method): self
    {
        return new static("Не удалось получить идентификатор чата при вызове метода [$method]");
    }

    public static function missingInputFileParam(string $field): self
    {
        $message = "В параметрах запроса пропущено поле [$field]. ";
        $message .= "Пожалуйста, убедитель, что файл существует и передан как SKprods\Telegram\Api\InputFile";

        return new static($message);
    }

    public static function invalidChatAction(array $validActions): self
    {
        return new static("Невалидное состояние чата! Оно должно быть одним из: " . implode(', ', $validActions));
    }
}