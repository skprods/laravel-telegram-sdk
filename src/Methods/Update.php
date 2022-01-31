<?php

namespace SKprods\Telegram\Methods;

use GuzzleHttp\Exception\ClientException;
use SKprods\Telegram\Api\InputFile;
use SKprods\Telegram\Exceptions\TelegramException;
use SKprods\Telegram\Objects\Update as UpdateObject;
use SKprods\Telegram\Objects\WebhookInfo;

trait Update
{
    /**
     * Используйте этот метод для получения входящих обновлений с помощью long polling.
     *
     * $params = [
     *   'offset'  => '',
     *   'limit'   => '',
     *   'timeout' => '',
     *   'allowed_updates' => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#getupdates
     *
     * @throws ClientException
     *
     * @return UpdateObject[]
     */
    public function getUpdates(array $params = [], $shouldEmitEvents = true): array
    {
        $response = $this->api->get('getUpdates', $params);

        return collect($response->getResult())
            ->map(function ($data) use ($shouldEmitEvents) {
                return new UpdateObject($data);
            })
            ->all();
    }

    /**
     * Установка Webhook для получения входящих обновлений через webhook.
     *
     * $params = [
     *   'url'         => '',
     *   'certificate' => '',
     *   'max_connections' => '',
     *   'allowed_updates' => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#setwebhook
     *
     * @throws TelegramException
     */
    public function setWebhook(array $params): bool
    {
        $this->validateHookUrl($params['url']);

        if (isset($params['certificate'])) {
            $params['certificate'] = $this->formatCertificate($params['certificate']);
            $response = $this->api->uploadFile('setWebhook', $params, 'certificate')->getResult();
            return $response['result'] ?? false;
        }

        $response = $this->api->post('setWebhook', $params)->getResult();
        return $response['result'] ?? false;
    }

    /**
     * Удалить интеграцию с Telegram через webhook
     *
     * @link https://core.telegram.org/bots/api#deletewebhook
     *
     * @throws ClientException
     */
    public function deleteWebhook(): bool
    {
        $response = $this->api->get('deleteWebhook')->getResult();

        return $response['result'];
    }

    /**
     * Получение текущего статуса вебхука
     *
     * @link https://core.telegram.org/bots/api#getwebhookinfo
     *
     * @throws ClientException
     */
    public function getWebhookInfo(): WebhookInfo
    {
        $response = $this->api->get('getWebhookInfo');

        return new WebhookInfo($response->getResult());
    }

    /**
     * Возвращает обновление из Telegram
     *
     * Работает только если установлен webhook
     * @see setWebhook
     */
    public function getWebhookUpdate(): UpdateObject
    {
        $body = json_decode(file_get_contents('php://input'), true);

        return new UpdateObject($body);
    }

    /**
     * Валидация адреса вебхука
     *
     * @throws TelegramException
     */
    private function validateHookUrl(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new TelegramException('Невалидный URL адрес');
        }

        if (parse_url($url, PHP_URL_SCHEME) !== 'https') {
            throw new TelegramException('Невалидный URL адрес, он должен быть HTTPS');
        }
    }

    /**
     * Подготовка сертификата к отправке с помощью InputFile
     */
    private function formatCertificate($certificate): InputFile
    {
        if ($certificate instanceof InputFile) {
            return $certificate;
        }

        return InputFile::create($certificate, 'certificate.pem');
    }
}
