<?php

namespace SKprods\Telegram\Core;

use Exception;
use SKprods\Telegram\Core\History\ChatInfo;
use SKprods\Telegram\Core\History\Dialog as HistoryDialog;
use SKprods\Telegram\Exceptions\TelegramException;
use SKprods\Telegram\Objects\MessageEntity;
use SKprods\Telegram\Objects\Update;

abstract class Dialog extends Interaction
{
    /**
     * Шаги диалога, которые необходимо пройти после запуска
     *
     * Шаги должны называться так же, как и функции для их обработки,
     * за исключением постфикса Step. Например, у вас указано 3 шага:
     * - name
     * - surname
     * - userAge
     *
     * Тогда функции для их обработки должны называться вот так:
     * - nameStep
     * - surnameStep
     * - userAgeStep
     *
     * Также каждый диалог начинается с какой-то команды. Она определяется
     * аналогично @see Command: вы указываете $name и $description, а
     * обработка будет в методе handle().
     */
    protected array $steps = [];

    /**
     * Индикатор того, что шаг завершён. Если не нужно завершать
     * шаг, например, когда пользователь ввёл некорректные данные
     * и должен повторить ввод, проставьте его в значение false.
     */
    protected bool $stepCompleted = true;

    /** Инициализация диалога для обработки сообщения */
    public function make(Telegram $telegram, Update $update, ChatInfo $chatInfo, MessageEntity $entity = null)
    {
        $this->telegram = $telegram;
        $this->update = $update;
        $this->entity = $entity;

        if ($this->entity) {
            $this->setArguments();
        } else {
            /** В данном случае currentCommand - команда, которая начала диалог */
            $this->arguments = $chatInfo->currentCommand->arguments;
        }

        $this->chatInfo = $this->prepareChatInfo($chatInfo);

        $this->run();
    }

    /**
     * Обработка диалога
     *
     * Так как диалог инициализируется с помощью команды, сначала следует проверка,
     * является ли полученное сообщение стартовой командой. Если является, обработка
     * уходит в метод handle(), аналогичный обработке команды в Command.
     *
     * Если же полученное сообщение - не команда, начинается обработка шагов диалога.
     * Все шаги должны быть описаны в массиве @see $steps
     *
     * Если текущий шаг не удалось определить, вызовется @throws TelegramException
     * с методом invalidDialogStep.
     *
     * Во время обработки вы можете использовать всю необходимую информацию:
     * - свойство @see Telegram $telegram для взаимодействия с API Telegram;
     * - свойство @see Update $update для получения информации о полученном сообщении;
     *
     * @throws Exception
     */
    protected function run()
    {
        /** Метод можно переопределить для выполнения кода до основной обработки */
        $this->beforeHandle();

        /** Если диалог вызван командой, отрабатывает обработчик команды */
        if ($this->checkInitCommand()) {
            $this->handleCommand();
            return;
        }

        $currentStep = $this->getCurrentStep();
        if (!$currentStep) {
            throw TelegramException::invalidDialogStep($this);
        }

        try {
            /** Обработка текущего шага диалога */
            $this->{$currentStep . "Step"}();
        } catch (Exception $exception) {
            $this->handleException($exception);
        }

        /** Метод можно переопределить для выполнения кода после основной обработки */
        $this->afterHandle();

        /** Сохранение информации о текущем шаге */
        $this->completeStep($currentStep);
    }

    private function checkInitCommand(): bool
    {
        return (bool) $this->update->message->entities;
    }

    /**
     * Инициализация обработки команды, вызвавшей диалог
     *
     * @throws Exception
     */
    private function handleCommand()
    {
        try {
            /** Очистка данных от предыдущего диалога (если есть) */
            $this->clearDialog();

            /** Обработка команды-инициатора диалога */
            $this->handle();
        } catch (Exception $exception) {
            $this->handleException($exception);
        }

        /** Метод можно переопределить для выполнения кода после основной обработки */
        $this->afterHandle();

        $this->chatInfo->save();
    }

    protected function getCurrentStep()
    {
        $completedSteps = $this->chatInfo->dialog->completedSteps;

        if (empty($completedSteps)) {
            $firstStepKey = array_key_first($this->steps);
            return $this->steps[$firstStepKey];
        }

        $lastStep = end($completedSteps);

        foreach ($this->steps as $key => $step) {
            if ($step === $lastStep) {
                return $this->steps[$key + 1] ?? null;
            }
        }

        return null;
    }

    /** Если вам нужна своя обработка ошибок, переопределите этот метод в своей команде */
    protected function handleException(Exception $exception)
    {
        throw $exception;
    }

    private function clearDialog()
    {
        $dialog = $this->chatInfo->dialog;

        $dialog->name = $this->name;
        $dialog->className = static::class;
        $dialog->status = HistoryDialog::ACTIVE_STATUS;
        $dialog->completedSteps = [];
        $dialog->data = [];

        $this->chatInfo->dialog = $dialog;
    }

    /** Сохранение информации о текущем шаге в ChatInfo, если stepCompleted = true */
    private function completeStep(string $currentStep)
    {
        if (!$this->stepCompleted) {
            return;
        }

        if (count($this->steps) === count($this->chatInfo->dialog->completedSteps)) {
            $this->chatInfo->dialog->status = HistoryDialog::COMPLETED_STATUS;
        } else {
            $this->chatInfo->dialog->status = HistoryDialog::ACTIVE_STATUS;
            $this->chatInfo->dialog->completedSteps[] = $currentStep;
        }

        $this->chatInfo->save();
    }
}