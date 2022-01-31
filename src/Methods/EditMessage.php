<?php

namespace SKprods\Telegram\Methods;

use GuzzleHttp\Exception\ClientException;
use SKprods\Telegram\Objects\Message;
use SKprods\Telegram\Objects\Poll;

trait EditMessage
{
    /**
     * Редактировать сообщение, отправленные ботом (для inline-ботов)
     *
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     *   'inline_message_id'        => '',
     *   'text'                     => '',
     *   'parse_mode'               => '',
     *   'disable_web_page_preview' => '',
     *   'reply_markup'             => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#editmessagetext
     *
     * @throws ClientException
     */
    public function editMessageText(array $params): Message
    {
        $response = $this->api->post('editMessageText', $params);

        return new Message($response->getResult());
    }

    /**
     * Изменить подпись к сообщению, отправленную ботом
     *
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     *   'inline_message_id'        => '',
     *   'caption'                  => '',
     *   'parse_mode'               => '',
     *   'reply_markup'             => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#editmessagecaption
     *
     * @throws ClientException
     */
    public function editMessageCaption(array $params): Message
    {
        $response = $this->api->post('editMessageCaption', $params);

        return new Message($response->getResult());
    }

    /**
     * Редактировать аудио, документ или видео сообщение, отправленное ботом
     *
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     *   'inline_message_id'        => '',
     *   'media'                    => '',
     *   'reply_markup'             => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#editmessagemedia
     *
     * @throws ClientException
     */
    public function editMessageMedia(array $params): Message
    {
        $response = $this->api->post('editMessageMedia', $params);

        return new Message($response->getResult());
    }

    /**
     * Изменить inline-клавиатуру, отправленную ботом
     *
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     *   'inline_message_id'        => '',
     *   'reply_markup'             => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#editmessagereplymarkup
     *
     * @throws ClientException
     */
    public function editMessageReplyMarkup(array $params): Message
    {
        $response = $this->api->post('editMessageReplyMarkup', $params);

        return new Message($response->getResult());
    }

    /**
     * Завершить опрос, созданный ботом
     *
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     *   'reply_markup'             => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#stoppoll
     *
     * @throws ClientException
     */
    public function stopPoll(array $params): Poll
    {
        $response = $this->api->post('stopPoll', $params);

        return new Poll($response->getResult());
    }

    /**
     * Удалить сообщение, включая служебные сообщения со следующими ограничениями:
     *
     * - Сообщение может быть удалено только в том случае, если оно было отправлено менее 48 часов назад.
     * - Боты могут удалять исходящие сообщения в личных чатах, группах и супергруппах.
     * - Боты могут удалять входящие сообщения в приватных чатах.
     * - Боты, которым предоставлены разрешения can_post_messages, могут удалять исходящие сообщения в каналах
     * - Если бот является администратором группы, он может удалить там любое сообщение.
     * - Если у бота есть разрешение can_delete_messages в супергруппе или канале, он может удалить любое сообщение там.
     *
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     * ];
     *
     * @throws ClientException
     */
    public function deleteMessage(array $params): ?array
    {
        $response = $this->api->post('deleteMessage', $params);

        return $response->getResult();
    }
}
