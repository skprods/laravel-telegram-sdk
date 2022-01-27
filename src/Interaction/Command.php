<?php

namespace SKprods\Telegram\Interaction;

use Illuminate\Support\Collection;
use SKprods\Telegram\Core\Telegram;
use SKprods\Telegram\Objects\MessageEntity;
use SKprods\Telegram\Objects\Update;
use SKprods\Telegram\Traits\CanRun;

abstract class Command extends Interaction
{
    use CanRun;

    protected MessageEntity $entity;

    /**
     * Имя команды, по которому она будет вызвана.
     *
     * Например, имя 'start' позволит вызвать команду, когда пользователь
     * введёт '/start'
     */
    public string $name = '';

    /**
     * Паттерн построения имени команды
     *
     * Например, паттерн "review {id} {status}" спарсит пользовательский
     * ввод "/review 1 active" в аргументы [ 'id' => 1, 'status' => 'active' ]
     */
    public string $pattern = '';

    /** Описание команды */
    public string $description = '';

    /**
     * Алиасы команды
     * Они могут быть полезны, чтобы вызывать команду по нескольким именам.
     *
     * Например, $name = review, $aliases = [ 'rev' ]. Команда будет вызвана
     * при вводе пользователем /review или /rev.
     */
    protected array $aliases = [];

    /**
     * Аргументы, переданные с командой
     *
     * Проставляются, если указан $pattern
     */
    protected array $arguments = [];

    /**
     * Обработка команды
     *
     * После определения аргументов начинается обработка полученного сообщения.
     * Она выполняется в методе handle(), который необходимо переопределить в
     * дочерних классах-обработчиках команды.
     *
     * Во время обработки вы можете использовать всю необходимую информацию:
     * - свойство @see Telegram $telegram для взаимодействия с API Telegram;
     * - свойство @see Update $update для получения информации о полученном сообщении;
     * - свойство @see MessageEntity $entity для получения информации о текущей команде
     *
     * Для более гибкой разработки предусмотрены методы beforeHandle() и
     * afterHandle(). Вы можете переопределить их в своих дочерних классах
     * для выполнения кода до и после основной обработки соответственно.
     * Это может пригодиться, например, для логгирования.
     */
    protected function run()
    {
        /** Метод можно переопределить для выполнения кода до основной обработки */
        $this->beforeHandle();

        /** Обработка команды */
        $this->handle();

        /** Метод можно переопределить для выполнения кода после основной обработки */
        $this->afterHandle();
    }

    /** Инициализация команды для обработки сообщения */
    public function make(Telegram $telegram, Update $update, MessageEntity $entity)
    {
        $this->telegram = $telegram;
        $this->update = $update;
        $this->entity = $entity;

        $this->parseArguments();
        $this->run();
    }

    /** Парсинг аргументов команды из сообщения */
    protected function parseArguments()
    {
        $required = $this->extractRegexValue('/\{([^\d]\w+?)\}/');
        $optional = $this->extractRegexValue('/\{([^\d]\w+?)\?\}/');

        $regex = $this->prepareRegex($required, $optional);
        preg_match($regex, $this->relevantMessageSubString(), $matches);

        $this->arguments = $this->formatMatches($matches, $required, $optional);
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
            return $this->update->message->text;
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
        return collect($matches)
            ->intersectByKeys(
                $required->merge($optional)->flip()
            )->all();
    }
}