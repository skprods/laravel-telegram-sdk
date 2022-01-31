<?php

namespace SKprods\Telegram\Methods;

use GuzzleHttp\Exception\ClientException;

trait Query
{
    /**
     * Используйте этот метод для отправки ответов на запросы обратного вызова, отправленные
     * со встроенных клавиатур. Ответ будет показан пользователю в виде уведомления в верхней
     * части экрана чата или в виде предупреждения.
     *
     * $params = [
     *   'callback_query_id'  => '',
     *   'text'               => '',
     *   'show_alert'         => '',
     *   'url'                => '',
     *   'cache_time'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#answercallbackquery
     *
     * @throws ClientException
     */
    public function answerCallbackQuery(array $params): bool
    {
        $response = $this->api->post('answerCallbackQuery', $params);

        return $response->getResult();
    }

    /**
     * Отправка ответа на встроенный запрос
     * Допускается не более 50 результатов на запрос.
     *
     * $params = [
     *   'inline_query_id'      => '',
     *   'results'              => [],
     *   'cache_time'           => 0,
     *   'is_personal'          => false,
     *   'next_offset'          => '',
     *   'switch_pm_text'       => '',
     *   'switch_pm_parameter'  => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#answerinlinequery
     *
     * @throws ClientException
     */
    public function answerInlineQuery(array $params): bool
    {
        $response = $this->api->post('answerInlineQuery', $params);

        return $response->getResult();
    }
}
