<?php

namespace SKprods\Telegram\Core;

use SKprods\Telegram\Api\Api;
use SKprods\Telegram\Interaction\Command;
use SKprods\Telegram\Entities\Config;
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
     * @var array
     */
    public array $dialogs;

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
        }
    }

    private function setDialogs()
    {
    }

    public function getWebhookUpdate(): Update
    {
        $body = json_decode(file_get_contents('php://input'), true);

        return new Update($body);
    }
}