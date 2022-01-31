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

            /**
             * Обработчик системных уведомлений от Telegram
             * Он должен наследоваться от @see SKprods\Telegram\Core\FreeHandler
             */
            'freeHandler' => null,
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

    /**
     * Конфигурация ChatInfo
     *
     * С помощью этой конфигурации можно настроить, где будет храниться
     * информация о чатах, такая как текущая и предыдущая команда, а также
     * информация о диалоге.
     *
     * По умолчанию поддерживаются три типа хранения: file, redis, custom.
     *
     * - file - хранение данных о чате в JSON-файле. Сам файл будет находиться
     * в storage/app/chatInfo.json;
     *
     * - redis - хранение данных о чате в Redis. В таком случае нужно обязательно
     * указать ключ connection, в котором указать название соединение. Найти его
     * можно в config/database.php в секции 'redis';
     *
     * - custom - кастомный обработчик хранения. Определите класс-обработчик в
     * ключе 'handler'. Он должен реализовывать этот интерфейс:
     * @see SKprods\Telegram\Writers\WriterInterface
     */
    'chatInfo' => [
        'driver' => 'file',
        'connection' => null,
        'handler' => null,
    ],
];
