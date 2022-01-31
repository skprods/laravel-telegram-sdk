<?php

namespace SKprods\Telegram\Methods;

use GuzzleHttp\Exception\ClientException;
use SKprods\Telegram\Objects\GameHighScore;
use SKprods\Telegram\Objects\Message;

trait Game
{
    /**
     * Отправить игру.
     *
     * $params = [
     *   'chat_id'                  => '',
     *   'game_short_name'          => '',
     *   'disable_notification'     => '',
     *   'reply_to_message_id'      => '',
     *   'reply_markup'             => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendgame
     *
     * @throws ClientException
     */
    public function sendGame(array $params): Message
    {
        $response = $this->api->post('sendGame', $params);

        return new Message($response->getResult());
    }

    /**
     * Установить счёт пользователя в игре
     *
     * $params = [
     *   'user_id'              => '',
     *   'score'                => '',
     *   'force'                => '',
     *   'disable_edit_message' => '',
     *   'chat_id'              => '',
     *   'message_id'           => '',
     *   'inline_message_id'    => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#setgamescore
     *
     * @throws ClientException
     */
    public function setGameScore(array $params): Message
    {
        $response = $this->api->post('setGameScore', $params);

        return new Message($response->getResult());
    }

    /**
     * Получение таблицы с баллами для пользователя
     * Метод вернёт счёт указанного пользователя и нескольких его соседей в игре
     *
     * $params = [
     *   'user_id'           => '',
     *   'chat_id'           => '',
     *   'message_id'        => '',
     *   'inline_message_id' => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#getgamehighscores
     *
     * @throws ClientException
     *
     * @return GameHighScore[]
     */
    public function getGameHighScores(array $params): array
    {
        $response = $this->api->get('getGameHighScores', $params);

        return collect($response->getResult())
            ->map(function ($data) {
                return new GameHighScore($data);
            })
            ->all();
    }
}
