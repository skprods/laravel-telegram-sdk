<?php

namespace SKprods\Telegram\Interaction;

use Illuminate\Support\Str;
use SKprods\Telegram\Core\Telegram;
use SKprods\Telegram\Exceptions\TelegramException;
use SKprods\Telegram\Objects\Message;
use SKprods\Telegram\Objects\Update;

/**
 * Отправка данных в Telegram, доступные методы:
 *
 * @method Message replyWithMessage(array $sendMessageParams)         Отправка сообщения
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendmessage
 * @method Message replyWithPhoto(array $sendPhotoParams)             Отправка фотографии
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendphoto
 * @method Message replyWithAudio(array $sendAudioParams)             Отправка аудио
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendaudio
 * @method Message replyWithDocument(array $sendDocumentParams)       Отправка документа
 * Допустимые параметры: @link https://core.telegram.org/bots/api#senddocument
 * @method Message replyWithVideo(array $sendVideoParams)             Отправка видео
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendvideo
 * @method Message replyWithAnimation(array $sendAnimationParams)     Отправка анимации
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendanimation
 * @method Message replyWithVoice(array $sendVoiceParams)             Отправка голосового сообщения
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendvoice
 * @method Message replyWithVideoNote(array $sendVideoNoteParams)     Отправка видеосообщения (кружок)
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendvideonote
 * @method array replyWithMediaGroup(array $sendMediaGroupParams)     Отправка альбома из фото, видео и т.д.
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendmediagroup
 * @method Message replyWithLocation(array $sendLocationParams)       Отправка геопозиции
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendlocation
 * @method Message replyWithVenue(array $sendVenueParams)             Отправка информации о месте встречи
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendvenue
 * @method Message replyWithContact(array $sendContactParams)         Отправка телефонного контакта
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendcontact
 * @method Message replyWithPoll(array $sendPollParams)               Отправка опроса
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendpoll
 * @method Message replyWithDice(array $sendDiceParams)               Отправка анимированного эмодзи
 * Допустимые параметры: @link https://core.telegram.org/bots/api#senddice
 * @method mixed replyWithChatAction(array $sendChatActionParams)     Отправка состояния
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendchataction
 * @method mixed replyWithSticker(array $sendStickerParams)           Отправка стикера
 * Допустимые параметры: @link https://core.telegram.org/bots/api#sendsticker
 *
 * @important
 * Примечание: если не указать chat_id, он будет получен автоматически, если отправляется
 * ответ на обновление из бота (ответ на команду, диалог и т.д.)
 *
 * @see \SKprods\Telegram\Methods\Message
 */
abstract class Interaction
{
    protected Telegram $telegram;
    protected Update $update;

    /** @throws TelegramException */
    public function __call(string $method, array $params)
    {
        if (Str::startsWith($method, 'replyWith')) {
            $params = $params[0];

            $chatId = $this->getChatId($method, $params);
            $params = array_merge($params, ['chat_id' => $chatId]);

            $replyName = Str::studly(substr($method, 9));
            $method = 'send'.$replyName;

            $this->reply($method, $params);
        } else {
            throw new \BadMethodCallException("Метод [$method] не существует.");
        }
    }

    private function reply(string $method, array $params)
    {
        $this->telegram->$method($params);
    }

    private function getChatId(string $method, array $params)
    {
        $chat = $this->update->getChat();

        if (!$chat && !isset($params['chat_id'])) {
            throw TelegramException::badMethodCall($method);
        }

        return $params['chat_id'] ?? $chat->id;
    }
}