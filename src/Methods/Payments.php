<?php

namespace SKprods\Telegram\Methods;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Arr;
use SKprods\Telegram\Objects\Message;

trait Payments
{
    /**
     * Отправить платёж
     *
     * $params = [
     *   'chat_id'                 => '',
     *   'title'                   => '',
     *   'description'             => '',
     *   'payload'                 => '',
     *   'provider_token'          => '',
     *   'start_parameter'         => '',
     *   'currency'                => '',
     *   'prices'                  => '',
     *   'photo_url'               => '',
     *   'photo_size'              => '',
     *   'photo_width'             => '',
     *   'photo_height'            => '',
     *   'need_name'               => '',
     *   'need_phone_number'       => '',
     *   'need_email'              => '',
     *   'need_shipping_address'   => '',
     *   'is_flexible'             => '',
     *   'disable_notification'    => '',
     *   'reply_to_message_id'     => '',
     *   'reply_markup'            => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendinvoice
     *
     * @throws ClientException
     */
    public function sendInvoice(array $params): Message
    {
        $params['prices'] = json_encode(Arr::wrap($params['prices']));
        $response = $this->api->post('sendInvoice', $params);

        return new Message($response->getResult());
    }

    /**
     * Ответ на запрос о доставке
     *
     * $params = [
     *   'shipping_query_id'  => '',
     *   'ok'                 => '',
     *   'shipping_options'   => '',
     *   'error_message'      => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#answershippingquery
     *
     * @throws ClientException
     */
    public function answerShippingQuery(array $params): bool
    {
        $response = $this->api->post('answerShippingQuery', $params);

        return $response->getResult();
    }

    /**
     * Ответ на запросы перед оформлением заказа
     *
     * $params = [
     *   'pre_checkout_query_id'  => '',
     *   'ok'                     => '',
     *   'error_message'          => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#answerprecheckoutquery
     *
     * @throws ClientException
     */
    public function answerPreCheckoutQuery(array $params): bool
    {
        $response = $this->api->post('answerPreCheckoutQuery', $params);

        return $response->getResult();
    }
}
