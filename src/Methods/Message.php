<?php

namespace SKprods\Telegram\Methods;

use GuzzleHttp\Exception\ClientException;
use SKprods\Telegram\Api\InputFile;
use SKprods\Telegram\Exceptions\TelegramException;
use SKprods\Telegram\Objects\Message as MessageObject;

trait Message
{
    /**
     * Отправить сообщение
     *
     * $params = [
     *   'chat_id'                  => '',
     *   'text'                     => '',
     *   'parse_mode'               => '',
     *   'disable_web_page_preview' => '',
     *   'disable_notification'     => '',
     *   'reply_to_message_id'      => '',
     *   'reply_markup'             => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendmessage
     *
     * @throws ClientException
     */
    public function sendMessage(array $params): MessageObject
    {
        $response = $this->api->post('sendMessage', $params);

        return new MessageObject($response->getResult());
    }

    /**
     * Переслать сообщение в другой чат
     *
     * $params = [
     *   'chat_id'              => '',
     *   'from_chat_id'         => '',
     *   'disable_notification' => '',
     *   'message_id'           => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#forwardmessage
     *
     * @throws TelegramException|ClientException
     */
    public function forwardMessage(array $params): MessageObject
    {
        $response = $this->api->post('forwardMessage', $params);

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить фотографию
     *
     * В качестве фотографии нужно использовать stream resource. Например,
     * Illuminate\Support\Facades\Storage::readStream('path/to/file.jpg')
     *
     * $params = [
     *   'chat_id'              => '',
     *   'photo'                => InputFile::create($streamResourceOrUrl, $filename),
     *   'caption'              => '',
     *   'parse_mode'           => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendphoto
     *
     * @throws TelegramException|ClientException
     */
    public function sendPhoto(array $params): MessageObject
    {
        $response = $this->api->uploadFile('sendPhoto', $params, 'photo');

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить аудио-файл
     *
     * $params = [
     *   'chat_id'              => '',
     *   'audio'                => InputFile::create($streamResourceOrUrl, $filename),
     *   'caption'              => '',
     *   'parse_mode'           => '',
     *   'duration'             => '',
     *   'performer'            => '',
     *   'title'                => '',
     *   'thumb'                => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendaudio
     *
     * @throws TelegramException|ClientException
     */
    public function sendAudio(array $params): MessageObject
    {
        $response = $this->api->uploadFile('sendAudio', $params, 'audio');

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить файл документом
     *
     * $params = [
     *   'chat_id'              => '',
     *   'document'             => InputFile::create($streamResourceOrUrl, $filename),
     *   'thumb'                => '',
     *   'caption'              => '',
     *   'parse_mode'           => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#senddocument
     *
     * @throws TelegramException|ClientException
     */
    public function sendDocument(array $params): MessageObject
    {
        $response = $this->api->uploadFile('sendDocument', $params, 'document');

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить видео
     * Приложения Telegram поддерживают видео в формате mp4. Для остальных форматов
     * можно отправить видео как документ @see sendDocument()
     *
     * $params = [
     *   'chat_id'              => '',
     *   'video'                => InputFile::create($streamResourceOrUrl, $filename),
     *   'duration'             => '',
     *   'width'                => '',
     *   'height'               => '',
     *   'thumb'                => '',
     *   'caption'              => '',
     *   'parse_mode'           => '',
     *   'supports_streaming'   => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendvideo
     *
     * @throws TelegramException|ClientException
     */
    public function sendVideo(array $params): MessageObject
    {
        $response = $this->api->uploadFile('sendVideo', $params, 'video');

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить анимированные файлы (GIF or H.264/MPEG-4 AVC видео без звука)
     *
     * $params = [
     *   'chat_id'              => '',
     *   'animation'            => InputFile::create($streamResourceOrUrl, $filename),
     *   'duration'             => '',
     *   'width'                => '',
     *   'height'               => '',
     *   'thumb'                => '',
     *   'caption'              => '',
     *   'parse_mode'           => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendanimation
     *
     * @throws TelegramException|ClientException
     */
    public function sendAnimation(array $params): MessageObject
    {
        $response = $this->api->uploadFile('sendAnimation', $params, 'animation');

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить голосовой аудио-файл
     *
     * $params = [
     *   'chat_id'              => '',
     *   'voice'                => InputFile::create($streamResourceOrUrl, $filename),
     *   'caption'              => '',
     *   'parse_mode'           => '',
     *   'duration'             => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendvoice
     *
     * @throws TelegramException|ClientException
     */
    public function sendVoice(array $params): MessageObject
    {
        $response = $this->api->uploadFile('sendVideo', $params, 'video');

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить mp4 видео до 1 минуты в виде круга
     * Используйте этот метод для отправки видео-сообщений
     *
     * $params = [
     *   'chat_id'              => '',
     *   'video_note'           => InputFile::create($streamResourceOrUrl, $filename),
     *   'duration'             => '',
     *   'length'               => '',
     *   'thumb'                => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendvideonote
     *
     * @throws TelegramException|ClientException
     */
    public function sendVideoNote(array $params): MessageObject
    {
        $response = $this->api->uploadFile('sendVideoNote', $params, 'video_note');

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить группу фотографий и/или видео альбомом
     *
     * $params = [
     *   'chat_id'              => '',
     *   'media'                => [],
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     * ];
     *
     * Ключ 'media' - массив объектов InputFile с описанием фото/видео. В этом
     * действии необходимо ОБЯЗАТЕЛЬНО указать у каждого файла его тип. Он передаётся
     * третьим параметром при создании InputFile::create() и должен быть одним из
     * перечисленных типов: @see InputFile::FILE_TYPES
     *
     * @link https://core.telegram.org/bots/api#sendmediagroup
     *
     * @throws TelegramException|ClientException
     */
    public function sendMediaGroup(array $params): MessageObject
    {
        $response = $this->api->uploadFile('sendMediaGroup', $params, 'media');

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить информацию о встрече
     *
     * $params = [
     *   'chat_id'              => '',
     *   'latitude'             => '',
     *   'longitude'            => '',
     *   'title'                => '',
     *   'address'              => '',
     *   'foursquare_id'        => '',
     *   'foursquare_type'      => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendvenue
     *
     * @throws ClientException
     */
    public function sendVenue(array $params): MessageObject
    {
        $response = $this->api->post('sendVenue', $params);

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить телефонный контакт
     *
     * $params = [
     *   'chat_id'              => '',
     *   'phone_number'         => '',
     *   'first_name'           => '',
     *   'last_name'            => '',
     *   'vcard'                => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendcontact
     *
     * @throws ClientException
     */
    public function sendContact(array $params): MessageObject
    {
        $response = $this->api->post('sendContact', $params);

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить опрос
     * Опрос не может быть отправлен в приватный чат
     *
     * $params = [
     *   'chat_id'              => '',
     *   'question'             => '',
     *   'options'              => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendpoll
     *
     * @throws ClientException
     */
    public function sendPoll(array $params): MessageObject
    {
        $response = $this->api->post('sendPoll', $params);

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить кубик
     * Используйте этот метод, чтобы отправить кубик. Он выберет случайное
     * значение от 1 до 6
     *
     * $params = [
     *   'chat_id'              => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#senddice
     *
     * @throws ClientException
     */
    public function sendDice(array $params): MessageObject
    {
        $response = $this->api->post('sendDice', $params);

        return new MessageObject($response->getResult());
    }

    /**
     * Отправить состояние
     *
     * $params = [
     *   'chat_id' => '',
     *   'action'  => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#sendchataction
     *
     * @throws TelegramException|ClientException
     */
    public function sendChatAction(array $params): bool
    {
        $validActions = [
            'typing',
            'upload_photo',
            'record_video',
            'upload_video',
            'record_audio',
            'upload_audio',
            'upload_document',
            'find_location',
            'record_video_note',
            'upload_video_note',
        ];

        if (isset($params['action']) && in_array($params['action'], $validActions)) {
            $this->api->post('sendChatAction', $params);

            return true;
        }

        throw TelegramException::invalidChatAction($validActions);
    }
}