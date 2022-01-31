<?php

namespace SKprods\Telegram\Api;

use GuzzleHttp\Exception\ClientException;
use SKprods\Telegram\Clients\ClientInterface;
use SKprods\Telegram\Exceptions\TelegramException;

class Api
{
    const BASE_BOT_URL = 'https://api.telegram.org/bot';

    private ClientInterface $handler;

    private string $accessToken;

    public function __construct(ClientInterface $handler, string $accessToken)
    {
        $this->handler = $handler;
        $this->accessToken = $accessToken;
    }

    /** @throws ClientException */
    public function get(string $endpoint, array $params = []): Response
    {
        $url = $this->getUrl($endpoint);
        $request = new Request(Request::GET_METHOD, $url, $params);

        return $this->handler->get($request);
    }

    /** @throws ClientException */
    public function post(string $endpoint, array $params = []): Response
    {
        $url = $this->getUrl($endpoint);
        $request = new Request(Request::POST_METHOD, $url, $params);

        return $this->handler->post($request);
    }

    /** @throws TelegramException|ClientException */
    public function uploadFile(string $endpoint, array $params, string $fileField): Response
    {
        if (!isset($params[$fileField])) {
            throw TelegramException::missingInputFileParam($fileField);
        }

        $url = $this->getUrl($endpoint);
        $request = new Request(Request::POST_METHOD, $url, $this->getMultiprartParams($params, $fileField));

        return $this->handler->file($request);
    }

    private function getUrl(string $endpoint): string
    {
        return self::BASE_BOT_URL . $this->accessToken . "/$endpoint";
    }

    private function getMultiprartParams(array $params, string $fileField): array
    {
        $multipart = [];

        foreach ($params as $key => $param) {
            if ($key === $fileField && $param instanceof InputFile) {
                $inputFileParams = $param->prepareToRequest();
                $inputFileParams['name'] = $key;

                $multipart[] = $inputFileParams;
            } elseif ($key === $fileField && is_array($param)) {
                $multipart = $this->getGroupMultipart($param, $multipart);
            } else {
                $multipart[] = [
                    'name' => $key,
                    'contents' => $param,
                ];
            }
        }

        return [
            'multipart' => $multipart,
        ];
    }

    private function getGroupMultipart(array $items, array $multipart): array
    {
        $key = 1;
        foreach ($items as $mediaItem) {
            if ($mediaItem instanceof InputFile) {
                $inputFileParams = $mediaItem->prepareToRequest();
                $inputFileParams['name'] = "media-$key";

                $multipart[] = [
                    'type' => $mediaItem->getType(),
                    'media' => "attach://media-$key",
                    'thumb' => $inputFileParams,
                ];

                $key++;
            }
        }

        return $multipart;
    }
}