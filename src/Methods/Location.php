<?php

namespace SKprods\Telegram\Methods;

use GuzzleHttp\Exception\ClientException;
use SKprods\Telegram\Objects\Message as MessageObject;

trait Location
{
    /**
     * Отправить точку на карте
     *
     * $params = [
     *   'chat_id'              => '',
     *   'latitude'             => '',
     *   'longitude'            => '',
     *   'live_period'          => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendlocation
     *
     * @throws ClientException
     */
    public function sendLocation(array $params): MessageObject
    {
        $response = $this->api->post('sendLocation', $params);

        return new MessageObject($response->getResult());
    }

    /**
     * Редактировать местоположение в реальном времени, отправленное ботом или через бота.
     *
     * $params = [
     *   'chat_id'              => '',
     *   'message_id'           => '',
     *   'inline_message_id'    => '',
     *   'latitude'             => '',
     *   'longitude'            => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#editmessagelivelocation
     *
     * @throws ClientException
     */
    public function editMessageLiveLocation(array $params): MessageObject|bool
    {
        $response = $this->api->post('editMessageLiveLocation', $params);

        return new MessageObject($response->getResult());
    }

    /**
     * Прекратить обновление местоположение в реальном времени
     *
     * $params = [
     *   'chat_id'              => '',
     *   'message_id'           => '',
     *   'inline_message_id'    => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#stopmessagelivelocation
     *
     * @throws ClientException
     */
    public function stopMessageLiveLocation(array $params): MessageObject|bool
    {
        $response = $this->api->post('stopMessageLiveLocation', $params);

        return new MessageObject($response->getResult());
    }
}
