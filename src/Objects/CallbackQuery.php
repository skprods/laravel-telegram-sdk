<?php

namespace SKprods\Telegram\Objects;

/**
 * @property string $id                     Unique identifier for this query
 * @property User $from                     Sender
 * @property Message|null $message          Optional. Message with the callback button that originated the query. Note that message content and message date will not be available if the message is too old
 * @property string|null $inlineMessageId   Optional. Identifier of the message sent via the bot in inline mode, that originated the query
 * @property string $chatInstance           Global identifier, uniquely corresponding to the chat to which the message with the callback button was sent. Useful for high scores in games
 * @property string|null $data              Optional. Data associated with the callback button. Be aware that a bad client can send arbitrary data in this field
 * @property string|null $gameShortName     Optional. Short name of a Game to be returned, serves as the unique identifier for the game
 *
 * @link https://core.telegram.org/bots/api#callbackquery
 */
class CallbackQuery extends BaseObject
{
    protected function casts(): array
    {
        return [
            'from' => User::class,
            'message' => Message::class,
        ];
    }

    /** Отделение данных от полученной команды */
    public function getParsedData(): string
    {
        [$commandName, $data] = explode('_', $this->data);

        return $data;
    }
}