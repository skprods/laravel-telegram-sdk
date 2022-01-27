<?php

namespace SKprods\Telegram;

use Illuminate\Support\Str;
use SKprods\Telegram\Core\Telegram;
use SKprods\Telegram\Exceptions\TelegramException;
use SKprods\Telegram\Objects\MessageEntity;
use SKprods\Telegram\Objects\Update;

class TelegramBotService
{
    protected Telegram $telegram;

    public function __construct()
    {
        $this->telegram = app(Telegram::class);
    }

    /**
     * Handle new telegram messages
     *
     * @param bool $webhook - use webhook to access new messages
     */
    public function handle(bool $webhook = false): string
    {
        return $webhook ? $this->handleSingle() : $this->handleMultiple();
    }

    protected function handleMultiple(): string
    {
        // array of Update -> handleSingle()
    }

    protected function handleSingle(Update $update = null): string
    {
        // вебхук:
        // 1. получить обновления
        // 2. проверить на кик
        // 3. проверить на колбек
        // 4. проверить на команду
        // 5. проверить на диалог

        if (!$update) {
            $update = $this->telegram->getWebhookUpdate();
        }

        /**
         * Проверка, должен ли бот обрабатывать сообщения от
         * пользователя и из этого чата.
         */
        if (!$this->checkAllowed($update)) {
            return 'ok';
        }

        if ($update->message || $update->editedMessage) {
            return $this->handleMessage($update);
        }

        if ($update->callbackQuery) {
            return $this->handleCallback($update);
        }

        return "ok";
    }

    protected function handleMessage(Update $update): string
    {
        $message = $update->message;

        if ($message->entities) {
            collect($message->entities)
                ->filter(function (MessageEntity $entity) {
                    return $entity->type === 'bot_command';
                })
                ->each(function (MessageEntity $entity) use ($update) {
                    $this->initCommand($update, $entity);
                });
        } else {
            if ($this->telegram->config->allowDialog) {
                $this->initDialog();
            } else {
                $this->initFreeHandler();
            }
        }

        return 'ok';
    }

    protected function initCommand(Update $update, MessageEntity $entity)
    {
        $name = $this->parseCommand($update->message->text, $entity->offset, $entity->length);

        $commands = $this->telegram->commands;
        $command = $commands[$name] ?? $commands['help'] ?? null;

        return ($command) ? $command->make($this->telegram, $update, $entity) : false;
    }

    protected function parseCommand($text, $offset, $length): string
    {
        if (trim($text) === '') {
            throw new TelegramException('Message is empty, Cannot parse for command');
        }

        $command = substr(
            $text,
            $offset + 1,
            $length - 1
        );

        // When in group - Ex: /command@MyBot
        if (Str::contains($command, '@') && Str::endsWith($command, ['bot', 'Bot'])) {
            $command = explode('@', $command);
            $command = $command[0];
        }

        return $command;
    }

    protected function initDialog()
    {
        
    }

    protected function initFreeHandler()
    {

    }

    protected function handleCallback(Update $update): string
    {

    }

    protected function checkAllowed(Update $update): bool
    {
        $user = $update->getUser();
        $userAllowed = !$user || $this->checkUserAllow($user->id);
        if (!$userAllowed) {
            return false;
        }

        $chat = $update->getChat();
        return $chat && $this->checkChatAllow($chat->id);
    }

    protected function checkUserAllow(int $chatId): bool
    {
        $allowedChats = $this->telegram->config->allowedUsers;

        if (empty($allowedChats)) {
            return true;
        }

        return in_array($chatId, $allowedChats);
    }

    protected function checkChatAllow(int $chatId): bool
    {
        $allowedGroups = $this->telegram->config->allowedChats;

        if (empty($allowedGroups)) {
            return true;
        }

        return in_array($chatId, $allowedGroups);
    }
}