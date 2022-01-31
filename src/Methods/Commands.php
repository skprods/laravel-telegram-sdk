<?php

namespace SKprods\Telegram\Methods;

use GuzzleHttp\Exception\ClientException;
use SKprods\Telegram\Objects\BotCommand;

trait Commands
{

    /**
     * Получить список команд бота
     *
     * @link https://core.telegram.org/bots/api#getmycommands
     *
     * @throws ClientException
     * @return BotCommand[]
     */
    public function getMyCommands(): array
    {
        $response = $this->api->get('getMyCommands');

        return collect($response->getResult())
            ->map(function ($botCommand) {
                return new BotCommand($botCommand);
            })
            ->all();
    }

    /**
     * Изменить список команд бота
     *
     * $params = [
     *   'commands' => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#setmycommands
     *
     * @throws ClientException
     */
    public function setMyCommands(array $params): bool
    {
        $params['commands'] = json_encode($params['commands']);

        return $this->api->post('setMyCommands', $params)->getResult();
    }
}
