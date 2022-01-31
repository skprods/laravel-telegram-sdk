<?php

namespace SKprods\Telegram\Core;

use SKprods\Telegram\Core\History\ChatInfo;
use SKprods\Telegram\Objects\MessageEntity;
use SKprods\Telegram\Objects\Update;

abstract class Command extends Interaction
{
    /** Инициализация команды для обработки сообщения */
    public function make(Telegram $telegram, Update $update, ChatInfo $chatInfo, MessageEntity $entity = null)
    {
        $this->telegram = $telegram;
        $this->update = $update;
        $this->entity = $entity;

        $this->setArguments();
        $this->chatInfo = $this->prepareChatInfo($chatInfo);

        $this->run();
    }

    /**
     * Обработка команды
     *
     * После определения аргументов начинается обработка полученного сообщения.
     * Она выполняется в методе handle(), который необходимо переопределить в
     * дочерних классах-обработчиках команды.
     *
     * Если вам нужна обработка ответов из inline-клавиатуры, переопределите
     * метод handleCallback() и сделайте обработку там.
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

        /** Обработка команды или ответа из inline-клавиатуры */
        try {
            if ($this->update->callbackQuery) {
                $this->handleCallback();
            } else {
                $this->handle();
            }
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }

        /** Метод можно переопределить для выполнения кода после основной обработки */
        $this->afterHandle();

        /** Сохраняем актуальную информацию о чате */
        $this->chatInfo->save();
    }

    /** Если вам нужна своя обработка ошибок, переопределите этот метод в своей команде */
    protected function handleException(\Exception $exception)
    {
        throw $exception;
    }
}