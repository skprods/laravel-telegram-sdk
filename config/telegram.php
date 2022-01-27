<?php

return [
    'bots' => [
        'default' => [
            /**
             *
             */
            'token'         => env('TELEGRAM_BOT_TOKEN'),
            'webhook_url'   => env('TELEGRAM_WEBHOOK_URL'),


            'allow_dialog'  => true,


            'commands'      => [

            ],


            'dialogs'       => [

            ],

            /**
             * Если бот должен обрабатывать сообщения из любых чатов (групповых
             * или приватных), оставьте этот массив пустым. Если же вы хотите
             * ограничить список обрабатываемых групп, укажите их ID в этом массиве.
             */
            'allowed_chats' => [],

            /**
             * Аналогично допустимым группам. Если бот должен обрабатывать
             * сообщения от ограниченного круга лиц, укажите их ID здесь.
             */
            'allowed_users' => [],
        ],
    ],

    /** Бот по умолчанию */
    'default' => 'default',

    /**
     * Http-клиент для отправки запросов в Telegram.
     *
     * Если встроенного функционала недостаточного, можно указать
     * кастомный обработчик, который должен реализовывать интерфейс
     * @see SKprods\Telegram\Clients\HttpClientInterface
     */
    'httpClient' => SKprods\Telegram\Clients\SkprodsHttpClient::class,
];
