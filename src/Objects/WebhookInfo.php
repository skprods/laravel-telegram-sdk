<?php

namespace SKprods\Telegram\Objects;

/**
 * Содержит информацию о текущем статусе вебхука
 *
 * @link https://core.telegram.org/bots/api#webhookinfo
 *
 * @property string $url                    URL-адрес webhook, может быть пустым, если он не указан
 * @property bool $hasCustomCertificate     True, если был представлен пользовательский сертификат
 * @property int $pendingUpdateCount        Число обновлений, ожидающих доставки
 * @property int $lastErrorDate             Опционально. Время последней ошибки, возникшей при доставке обновления
 * @property string $lastErrorMessage       Опционально. Сообщение о последней ошибке в читабельном виде
 * @property int $maxConnections            Опционально. Максимально допустимое количество одновременных подключений
 *                                          для доставки сообщений
 * @property array $allowedUpdates          Опционально. Список типов обновлений, на которые подписан бот. По умолчанию
 *                                          подписан на все
 */
class WebhookInfo extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }
}
