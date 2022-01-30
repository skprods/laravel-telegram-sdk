<?php

namespace SKprods\Telegram;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SKprods\Telegram\Core\Dialog;
use SKprods\Telegram\Core\History\ChatInfo;
use SKprods\Telegram\Core\History\Dialog as HistoryDialog;
use SKprods\Telegram\Core\Interaction;
use SKprods\Telegram\Core\Telegram;
use SKprods\Telegram\Exceptions\TelegramException;
use SKprods\Telegram\Objects\MessageEntity;
use SKprods\Telegram\Objects\Update;
use SKprods\Telegram\Writers\Writer;
use SKprods\Telegram\Writers\WriterInterface;

class TelegramBotService
{
    protected Telegram $telegram;
    protected WriterInterface $writer;
    protected ?ChatInfo $chatInfo = null;

    public function __construct()
    {
        $this->telegram = app(Telegram::class);
        $this->writer = Writer::getDriverFromConfig();
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

    /**
     * 1. Если в сообщении есть команда, обрабатывает команду
     * 2. Если команды нет, проверяет предыдущие вызовы на предмет диалога и то, завершен он или нет
     * 3. Если это не продолжение диалога, вызывает общий обработчик
     */
    protected function handleMessage(Update $update): string
    {
        $message = $update->message;

        $this->chatInfo = $this->writer->getChatInfo($update->getChat()->id);

        if ($message->entities) {
            /** Если у сообщения есть массив entities, значит, это команда */
            collect($message->entities)
                ->filter(function (MessageEntity $entity) {
                    return $entity->type === 'bot_command';
                })
                ->each(function (MessageEntity $entity) use ($update) {
                    $this->initCommand($update, $entity);
                });

            return 'ok';
        }

        /** Если включен функционал диалогов и есть активный диалог, инициируем обработку диалога */
        if ($this->telegram->config->allowDialog && $this->chatInfo->dialog->status === HistoryDialog::ACTIVE_STATUS) {
            $this->initDialog($update);
            return 'ok';
        }

        $this->initFreeHandler();
        return 'ok';
    }

    /**
     * Инициализация команды или диалога, который активируется
     * по полученной команде
     *
     * @throws TelegramException
     */
    protected function initCommand(Update $update, MessageEntity $entity): bool
    {
        $name = $this->parseCommand($update->message->text, $entity->offset, $entity->length);

        $commands = array_merge($this->telegram->commands, $this->telegram->dialogs);
        $aliases = $this->telegram->aliases;

        $command = $commands[$name] ?? $aliases[$name] ?? $this->getPatternCommand($name) ?? $commands['help'] ?? null;

        if ($command) {
            $command->make($this->telegram, $update, $this->chatInfo, $entity);
            return true;
        }

        return false;
    }

    private function getPatternCommand(string $name): ?Interaction
    {
        $name = "/$name";

        $patterns = $this->telegram->patterns;
        foreach ($patterns as $pattern => $interaction) {
            preg_match($pattern, $name, $matches);

            if (!empty($matches)) {
                return $interaction;
            }
        }

        return null;
    }

    /**
     * Парсинг команды из сообщения
     *
     * @throws TelegramException
     */
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

    protected function initDialog(Update $update): bool
    {
        $chatDialog = $this->chatInfo->dialog;

        /** @var Dialog $dialog */
        $dialog = $this->telegram->dialogs[$chatDialog->name];

        if ($dialog) {
            $dialog->make($this->telegram, $update, $this->chatInfo);
            return true;
        }

        return false;
    }

    protected function initFreeHandler()
    {
        // TODO
    }

    protected function handleCallback(Update $update): string
    {
        // TODO
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
