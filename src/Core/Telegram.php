<?php

namespace SKprods\Telegram\Core;

use SKprods\Telegram\Api\Api;
use SKprods\Telegram\Methods\Message;
use SKprods\Telegram\Objects\Update;

class Telegram
{
    use Message;

    /** Версия библиотеки */
    const VERSION = '0.0.0';

    /** Конфигурация обрабатываемого бота */
    public Config $config;

    protected Api $api;

    /**
     * Зарегистрированные команды
     * @var Command[]
     */
    public array $commands;

    /**
     * Зарегистрированные диалоги
     * @var Dialog[]
     */
    public array $dialogs;

    /**
     * Алиасы команд и диалогов
     */
    public array $aliases = [];

    /**
     * Паттерны определения аргументов
     *
     * В этом массиве хранятся все паттерны команд и диалогов,
     * позволяющих выделить из сообщения с командой аргументы.
     * Хранится в формате pattern => InteractionInstance
     */
    public array $patterns = [];

    public function __construct(string $botName = null)
    {
        $this->setBotConfig($botName);
        $this->setApi();
        $this->setCommands();
        $this->setDialogs();
    }

    private function setBotConfig(?string $botName)
    {
        $botName = $botName ?? config('telegram.default');
        $config = config("telegram.bots.$botName");

        $this->config = Config::make($botName, $config);
    }

    private function setApi()
    {
        $httpClient = app(config('telegram.httpClient'));
        $this->api = new Api($httpClient, $this->config->token);
    }

    private function setCommands()
    {
        foreach ($this->config->commands as $className) {
            $command = app($className);
            $this->commands[$command->name] = $command;
            $this->addAliases($command);
            $this->addPattern($command);
        }
    }

    private function setDialogs()
    {
        foreach ($this->config->dialogs as $className) {
            $dialog = app($className);
            $this->dialogs[$dialog->name] = $dialog;
            $this->addAliases($dialog);
            $this->addPattern($dialog);
        }
    }

    private function addAliases(Interaction $interaction)
    {
        foreach ($interaction->aliases as $alias) {
            $this->aliases[$alias] = $interaction;
        }
    }

    private function addPattern(Interaction $interaction)
    {
        $pattern = $interaction->getRegexPattern();

        if ($pattern !== '') {
            $this->patterns[$pattern] = $interaction;
        }
    }

    public function getWebhookUpdate(): Update
    {
        $body = json_decode(file_get_contents('php://input'), true);

        return new Update($body);
    }
}