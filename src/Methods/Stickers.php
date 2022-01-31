<?php

namespace SKprods\Telegram\Methods;

use GuzzleHttp\Exception\ClientException;
use SKprods\Telegram\Exceptions\TelegramException;
use SKprods\Telegram\Objects\File;
use SKprods\Telegram\Objects\Message as MessageObject;
use SKprods\Telegram\Objects\StickerSet;

trait Stickers
{
    /**
     * Используйте этот метод для отправки статических .WEBP или анимированных .TGS стикеров
     *
     * $params = [
     *   'chat_id'              => '',
     *   'sticker'              => InputFile::create($streamResourceOrUrl, $filename),
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendsticker
     *
     * @throws TelegramException|ClientException
     */
    public function sendSticker(array $params): MessageObject
    {
        $response = $this->api->uploadFile('sendSticker', $params, 'sticker');

        return new MessageObject($response->getResult());
    }

    /**
     * Получить набор стикеров
     *
     * $params = [
     *   'name'              => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#getstickerset
     *
     * @throws ClientException
     */
    public function getStickerSet(array $params): StickerSet
    {
        $response = $this->api->post('getStickerSet', $params);

        return new StickerSet($response->getResult());
    }

    /**
     * Загрузите .png файл со стикером для последующего использования в методах
     * createNewStickerSet и addStickerToSet (можно использовать несколько раз).
     *
     * $params = [
     *   'user_id'              => '',
     *   'png_sticker'          => InputFile::create($resourceOrFile, $filename),
     * ];
     *
     * @link https://core.telegram.org/bots/api#uploadstickerfile
     *
     * @throws TelegramException|ClientException
     */
    public function uploadStickerFile(array $params): File
    {
        $response = $this->api->uploadFile('uploadStickerFile', $params, 'png_sticker');

        return new File($response->getResult());
    }

    /**
     * Создать новый набор наклеек, принадлежащий пользователю
     *
     * $params = [
     *   'user_id'           => '',
     *   'name'              => '',
     *   'title'             => '',
     *   'png_sticker'       => '',
     *   'tgs_sticker'       => '',
     *   'emojis'            => '',
     *   'contains_masks'    => '',
     *   'mask_position'     => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#createnewstickerset
     *
     * @throws ClientException|TelegramException
     */
    public function createNewStickerSet(array $params): bool
    {
        $response = $this->api->uploadFile('createNewStickerSet', $params, 'png_sticker');

        return $response->getResult();
    }

    /**
     * Добавить новый стикер в набор, созданный ботом.
     *
     * $params = [
     *   'user_id'           => '',
     *   'name'              => '',
     *   'png_sticker'       => '',
     *   'tgs_sticker'       => '',
     *   'emojis'            => '',
     *   'mask_position'     => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#addstickertoset
     *
     * @throws TelegramException|ClientException
     */
    public function addStickerToSet(array $params): bool
    {
        $response = $this->api->uploadFile('addStickerToSet', $params, 'png_sticker');

        return $response->getResult();
    }

    /**
     * Переместить наклейку в наборе, созданном ботом, в определенное положение.
     *
     * $params = [
     *   'sticker'  => '',
     *   'position' => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#setstickerpositioninset
     *
     * @throws ClientException
     */
    public function setStickerPositionInSet(array $params): bool
    {
        $response = $this->api->post('setStickerPositionInSet', $params);

        return $response->getResult();
    }

    /**
     * Удалить стикер из набора, созданного ботом.
     *
     * $params = [
     *   'sticker' => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#deletestickerfromset
     *
     * @throws ClientException
     */
    public function deleteStickerFromSet(array $params): bool
    {
        $response = $this->api->post('deleteStickerFromSet', $params);

        return $response->getResult();
    }

    /**
     * Установка миниатюры набора наклеек
     *
     * $params = [
     *   'name'          => '',
     *   'user_id'       => '',
     *   'thumb'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#setstickersetthumb
     *
     * @throws TelegramException|ClientException
     */
    public function setStickerSetThumb(array $params): bool
    {
        $response = $this->api->uploadFile('setStickerSetThumb', $params, 'thumb');

        return $response->getResult();
    }

}
