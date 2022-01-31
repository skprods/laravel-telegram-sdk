<?php

namespace SKprods\Telegram\Methods;

use GuzzleHttp\Exception\ClientException;
use SKprods\Telegram\Objects\File;
use SKprods\Telegram\Objects\User;
use SKprods\Telegram\Objects\UserProfilePhotos;

trait Get
{
    /**
     * Метод для проверки токена авторизации бота
     * Возвращает основную информацию о боте в виде объекта User
     *
     * @link https://core.telegram.org/bots/api#getme
     *
     * @throws ClientException
     */
    public function getMe(): User
    {
        $response = $this->api->get('getMe');

        return new User($response->getResult());
    }

    /**
     * Получить список изображений профиля пользователя
     *
     * $params = [
     *   'user_id' => '',
     *   'offset'  => '',
     *   'limit'   => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#getuserprofilephotos
     *
     * @throws ClientException
     */
    public function getUserProfilePhotos(array $params): UserProfilePhotos
    {
        $response = $this->api->get('getUserProfilePhotos', $params);

        return new UserProfilePhotos($response->getResult());
    }

    /**
     * Возвращает основную информацию о файле и подготавливает его к загрузке
     *
     * $params = [
     *   'file_id' => '',
     * ];
     *
     * Файл можно загрузить по ссылке
     * https://api.telegram.org/file/bot<token>/<file_path>,
     * где <file_path> берётся из ответа
     *
     * @link https://core.telegram.org/bots/api#getFile
     *
     * @throws ClientException
     */
    public function getFile(array $params): File
    {
        $response = $this->api->get('getFile', $params);

        return new File($response->getResult());
    }
}
