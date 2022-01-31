<?php

namespace SKprods\Telegram\Core;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use SKprods\Telegram\Core\History\ChatInfo;
use SKprods\Telegram\Exceptions\TelegramException;
use SKprods\Telegram\Objects\Message;
use SKprods\Telegram\Objects\MessageEntity;
use SKprods\Telegram\Objects\Update;
use SKprods\Telegram\Traits\CanRun;

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
    use CanRun;

    protected Telegram $telegram;
    protected Update $update;
    protected ?MessageEntity $entity;

    /** Информация о текущем и предыдущих вызовах от пользователя */
    protected ChatInfo $chatInfo;

    /**
     * Имя команды или диалога, по которому они будут вызваны
     *
     * Например, имя 'start' позволит вызвать команду или диалог,
     * когда пользователь введёт '/start'
     */
    public string $name = '';

    /**
     * Паттерн построения имени команды или диалога
     *
     * Например, паттерн "review {id} {status}" спарсит пользовательский
     * ввод "/review 1 active" в аргументы [ 'id' => 1, 'status' => 'active' ]
     */
    public string $pattern = '';

    /** Описание команды или диалога */
    public string $description = '';

    /**
     * Алиасы команды или диалога
     * Они могут быть полезны, чтобы вызывать команду по нескольким именам.
     *
     * Например, $name = review, $aliases = [ 'rev' ]. Команда будет вызвана
     * при вводе пользователем /review или /rev.
     */
    public array $aliases = [];

    /**
     * Аргументы, переданные с командой
     *
     * Проставляются, если указан $pattern
     */
    protected array $arguments = [];

    abstract public function make(Telegram $telegram, Update $update, ChatInfo $chatInfo, MessageEntity $entity = null);

    abstract protected function run();

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
    // TODO: вынести в отдельное место, возможно, отдельным классом или трейтом
    /** Парсинг аргументов команды из сообщения */
    protected function setArguments()
    {
        $required = $this->extractRegexValue('/\{([^\d]\w+?)\}/');
        $optional = $this->extractRegexValue('/\{([^\d]\w+?)\?\}/');

        $regex = $this->prepareRegex($required, $optional);
        preg_match($regex, $this->relevantMessageSubString(), $matches);

        $this->arguments = $this->formatMatches($matches, $required, $optional);
    }

    public function getRegexPattern(): string
    {
        $required = $this->extractRegexValue('/\{([^\d]\w+?)\}/');
        $optional = $this->extractRegexValue('/\{([^\d]\w+?)\?\}/');

        return $this->prepareRegex($required, $optional);
    }

    private function extractRegexValue($regex): Collection
    {
        preg_match_all($regex, $this->pattern, $matches);

        return collect($matches[1]);
    }

    private function prepareRegex(Collection $required, Collection $optional): string
    {
        $optionalBotName = '(?:@.+?bot)?(?:\s+?)?';

        $required = $required
            ->map(function ($varName) {
                return "(?P<$varName>[^ ]++)";
            })
            ->implode('\s+?');

        $optional = $optional
            ->map(function ($varName) {
                return "(?:\s+?(?P<$varName>[^ ]++))?";
            })
            ->implode('');

        return "%/{$this->name}{$optionalBotName}{$required}{$optional}%si";
    }

    private function relevantMessageSubString(): ?string
    {
        //Get all the bot_command offsets in the Update object
        $commandOffsets = $this->allCommandOffsets();

        if ($commandOffsets->isEmpty()) {
            $message = $this->update->getMessage();
            return $message->text;
        }

        //Extract the current offset for this command and, if it exists, the offset of the NEXT bot_command entity
        $splice = $commandOffsets->splice(
            $commandOffsets->search($this->entity->offset),
            2
        );

        return $splice->count() === 2 ? $this->cutTextBetween($splice) : $this->cutTextFrom($splice);
    }

    private function cutTextBetween(Collection $splice): string
    {
        return substr(
            $this->update->message->text,
            $splice->first(),
            $splice->last() - $splice->first()
        );
    }

    private function cutTextFrom(Collection $splice): string
    {
        return substr(
            $this->update->message->text,
            $splice->first()
        );
    }

    private function allCommandOffsets(): Collection
    {
        $message = $this->update->message;
        if (!$message) {
            return collect();
        }

        $entities = collect($message->entities);

        if ($entities->contains('type', 'bot_command')) {
            return $entities->filter(function (MessageEntity $entity) {
                return $entity->type === 'bot_command';
            })->pluck('offset');
        } else {
            return collect();
        }
    }

    private function formatMatches(array $matches, Collection $required, Collection $optional): array
    {
        $arguments = collect($matches)
            ->intersectByKeys(
                $required->merge($optional)->flip()
            );

        $required->each(function ($field) use ($required, $arguments) {
            if (!$arguments->has($field)) {
                $this->handleInvalidArguments($required, $arguments);
            }
        });

        return $arguments->all();
    }

    /** Переопределите для кастомной обработки ошибки с обязательными аргументами */
    protected function handleInvalidArguments(Collection $required, Collection $arguments)
    {
        $requiredArgs = $required->implode(',');
        throw new \Exception("Не переданы обязательные аргументы! Убедитесь, что каждый присутствует: $requiredArgs");
    }

    protected function prepareChatInfo(ChatInfo $chatInfo): ChatInfo
    {
        $chatInfo->previousCommand = clone $chatInfo->currentCommand;
        $chatInfo->currentCommand->name = $this->name;
        $chatInfo->currentCommand->pattern = $this->pattern;
        $chatInfo->currentCommand->arguments = $this->arguments;
        $chatInfo->currentCommand->className = static::class;

        if (static::class instanceof Command) {
            $chatInfo->dialog = \SKprods\Telegram\Core\History\Dialog::create([]);
        }

        return $chatInfo;
    }

    public function getUpdate(): Update
    {
        return $this->update;
    }

    public function getChatInfo(): ChatInfo
    {
        return $this->chatInfo;
    }
}