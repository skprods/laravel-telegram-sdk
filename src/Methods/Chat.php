<?php

namespace SKprods\Telegram\Methods;

use GuzzleHttp\Exception\ClientException;
use SKprods\Telegram\Objects\Chat\ChatMember;
use SKprods\Telegram\Objects\Chat\Chat as ChatObject;

trait Chat
{
    /**
     * Забанить пользователя в группе или супергруппе
     *
     * В случае супергрупп, пользователь не сможет самостоятельно вернуться в группу, используя ссылки
     * для приглашения и т.п., пока он не будет разблокирован. Бот должен быть администратором в группе,
     * чтобы этот метод сработал.
     *
     * Примечание: Этот метод будет работать только в том случае, если в целевой группе отключен параметр
     * "Все участники являются администраторами". В противном случае участники могут быть удалены только
     * создателем группы или участником, который их добавил.
     *
     * $params = [
     *   'chat_id'      => '',
     *   'user_id'      => '',
     *   'until_date'   => ''
     * ];
     *
     * @link https://core.telegram.org/bots/api#banchatmember
     *
     * @throws ClientException
     */
    public function banChatMember(array $params): bool
    {
        return $this->api->get('banChatMember', $params)->getResult();
    }

    /**
     * Разбанить предыдущего забаненного пользователя в супергруппе
     *
     * Пользователь не вернётся в группу автоматически, но он сможет вернуться с помощью ссылки-приглашения
     * Бот должен быть администратором в группе, чтобы этот метод сработал.
     *
     * $params = [
     *   'chat_id' => '',
     *   'user_id' => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#unbanchatmember
     *
     * @throws ClientException
     */
    public function unbanChatMember(array $params): bool
    {
        return $this->api->get('unbanChatMember', $params)->getResult();
    }

    /**
     * Экспорт ссылки-приглашения в супергруппу или канал
     *
     * Бот должен быть администратором в группе, чтобы этот метод сработал.
     *
     * $params = [
     *   'chat_id' => ''
     * ];
     *
     * @link https://core.telegram.org/bots/api#exportchatinvitelink
     *
     * @throws ClientException
     */
    public function exportChatInviteLink(array $params): string
    {
        return $this->api->post('exportChatInviteLink', $params)->getResult();
    }

    /**
     * Установить новое фото группы
     *
     * Бот должен быть администратором в группе, чтобы этот метод сработал.
     *
     * $params = [
     *   'chat_id'  => ''
     *   'photo'    => ''
     * ];
     *
     * @link https://core.telegram.org/bots/api#setchatphoto
     *
     * @throws ClientException
     */
    public function setChatPhoto(array $params): bool
    {
        $response = $this->api->post('setChatPhoto', $params);

        return $response->getResult();
    }

    /**
     * Удалить фото чата
     *
     * Бот должен быть администратором в группе, чтобы этот метод сработал.
     *
     * $params = [
     *   'chat_id'  => ''
     * ];
     *
     * @throws ClientException
     */
    public function deleteChatPhoto(array $params): bool
    {
        $response = $this->api->post('deleteChatPhoto', $params);

        return $response->getResult();
    }

    /**
     * Установить название группы
     *
     * Бот должен быть администратором в группе, чтобы этот метод сработал.
     *
     * $params = [
     *   'chat_id'              => ''
     *   'title'                => ''
     * ];
     *
     * @link https://core.telegram.org/bots/api#setchatdescription
     *
     * @throws ClientException
     */
    public function setChatTitle(array $params): bool
    {
        $response = $this->api->post('setChatTitle', $params);

        return $response->getResult();
    }

    /**
     * Установить описание у супергруппы или канала
     *
     * Бот должен быть администратором в группе, чтобы этот метод сработал.
     *
     * $params = [
     *   'chat_id'              => ''
     *   'description'          => ''
     * ];
     *
     * @link https://core.telegram.org/bots/api#setchatdescription
     *
     * @throws ClientException
     */
    public function setChatDescription(array $params): bool
    {
        $response = $this->api->post('setChatDescription', $params);

        return $response->getResult();
    }

    /**
     * Закрепить сообщение в группе, супергруппе или канале
     *
     * Бот должен быть администратором в группе и иметь разрешение "Может закреплять сообщение" (для супергрупп)
     * или "Может редактировать сообщения" (для каналов).
     *
     * $params = [
     *   'chat_id'                   => ''
     *   'message_id'                => ''
     *   'disable_notification'      => ''
     * ];
     *
     * @link https://core.telegram.org/bots/api#pinchatmessage
     *
     * @throws ClientException
     */
    public function pinChatMessage(array $params): bool
    {
        $response = $this->api->post('pinChatMessage', $params);

        return $response->getResult();
    }

    /**
     * Открепить сообщение в группе, супергруппе или канале
     *
     * Бот должен быть администратором в группе и иметь разрешение "Может закреплять сообщение" (для супергрупп)
     * или "Может редактировать сообщения" (для каналов).
     *
     * $params = [
     *   'chat_id'              => ''
     * ];
     *
     * @link https://core.telegram.org/bots/api#unpinchatmessage
     *
     * @throws ClientException
     */
    public function unpinChatMessage(array $params): bool
    {
        $response = $this->api->post('unpinChatMessage', $params);

        return $response->getResult();
    }

    /**
     * Используйте этот метод, чтобы ваш бот покинул группу, супергруппу или канал
     *
     * $params = [
     *   'chat_id'              => ''
     * ];
     *
     * @link https://core.telegram.org/bots/api#leavechat
     *
     * @throws ClientException
     */
    public function leaveChat(array $params): bool
    {
        return $this->api->get('leaveChat', $params)->getResult();
    }

    /**
     * Ограничить пользователя в супергруппе
     *
     * Передайте значение True для всех параметров, чтобы снять ограничения с пользователя.
     * Бот должен быть администратором в группе, чтобы этот метод сработал.
     *
     * $params = [
     *   'chat_id'                     => '',
     *   'user_id'                     => '',
     *   'until_date'                  => '',
     *   'can_send_messages'           => '',
     *   'can_send_media_messages'     => '',
     *   'can_send_other_messages'     => '',
     *   'can_add_web_page_previews'   => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#restrictchatmember
     *
     * @throws ClientException
     */
    public function restrictChatMember(array $params): bool
    {
        $response = $this->api->post('restrictChatMember', $params);

        return $response->getResult();
    }

    /**
     * Изменить разрешения пользователя в супергруппе или канале
     *
     * Пеоредайте значение False для всех параметров, чтобы понизить пользователя в должности.
     * Бот должен быть администратором в группе, чтобы этот метод сработал.
     *
     * $params = [
     *   'chat_id'               => '',
     *   'user_id'               => '',
     *   'can_change_info'       => '',
     *   'can_post_messages'     => '',
     *   'can_edit_messages'     => '',
     *   'can_delete_messages'   => '',
     *   'can_invite_users'      => '',
     *   'can_restrict_members'  => '',
     *   'can_pin_messages'      => '',
     *   'can_promote_members'   => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#restrictchatmember
     *
     * @throws ClientException
     */
    public function promoteChatMember(array $params): bool
    {
        $response = $this->api->post('promoteChatMember', $params);

        return $response->getResult();
    }

    /**
     * Используйте этот метод, чтобы задать пользовательский заголовок для
     * администратора в супергруппе, управляемой ботом
     *
     * $params = [
     *   'chat_id'               => '',
     *   'user_id'               => '',
     *   'custom_title'           => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     *
     * @throws ClientException
     */
    public function setChatAdministratorCustomTitle(array $params): bool
    {
        $response = $this->api->post('setChatAdministratorCustomTitle', $params);

        return $response->getResult();
    }

    /**
     * Используйте этот метод, чтобы установить права по умолчанию для всех пользователей
     *
     * Бот должен быть администратором в группе и иметь право "Может блокировать пользователей",
     * чтобы этот метод сработал.
     *
     * $params = [
     *   'chat_id'               => '',
     *   'permissions'           => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#setchatpermissions
     *
     * @throws ClientException
     */
    public function setChatPermissions(array $params): bool
    {
        $response = $this->api->post('setChatPermissions', $params);

        return $response->getResult();
    }

    /**
     * Получайте актуальную информацию о чате (текущее имя пользователя для разговоров один на один,
     * текущее имя пользователя пользователя, группы или канала и т.д.).
     *
     * $params = [
     *   'chat_id'  => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#getchat
     *
     * @throws ClientException
     */
    public function getChat(array $params): ChatObject
    {
        $response = $this->api->get('getChat', $params);

        return new ChatObject($response->getResult());
    }

    /**
     * Получить список администраторов грууппы
     *
     * $params = [
     *   'chat_id'  => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#getchatadministrators
     *
     * @throws ClientException
     *
     * @return ChatMember[]
     */
    public function getChatAdministrators(array $params): array
    {
        $response = $this->api->get('getChatAdministrators', $params);

        return collect($response->getResult())
            ->map(function ($admin) {
                return new ChatMember($admin);
            })
            ->all();
    }

    /**
     * Получить число пользователей чата
     *
     * $params = [
     *   'chat_id'  => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#getchatmemberscount
     *
     * @throws ClientException
     */
    public function getChatMembersCount(array $params): int
    {
        return $this->api->get('getChatMembersCount', $params)->getResult();
    }

    /**
     * Получить информацию о пользователе чата
     *
     * $params = [
     *   'chat_id'  => '',
     *   'user_id'  => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#getchatmember
     *
     * @throws ClientException
     */
    public function getChatMember(array $params): ChatMember
    {
        $response = $this->api->get('getChatMember', $params);

        return new ChatMember($response->getResult());
    }

    /**
     * Добавить новый набор стикеров для группы
     *
     * Бот должен быть администратором в группе, чтобы этот метод сработал.
     *
     * $params = [
     *   'chat_id'                   => ''
     *   'sticker_set_name'          => ''
     * ];
     *
     * @link https://core.telegram.org/bots/api#setchatstickerset
     *
     * @throws ClientException
     */
    public function setChatStickerSet(array $params): bool
    {
        $response = $this->api->post('setChatStickerSet', $params);

        return $response->getResult();
    }

    /**
     * Удалить набор стикеров для группы
     *
     * Бот должен быть администратором в группе, чтобы этот метод сработал.
     *
     * $params = [
     *   'chat_id'                   => ''
     * ];
     *
     * @link https://core.telegram.org/bots/api#deletechatstickerset
     *
     * @throws ClientException
     */
    public function deleteChatStickerSet(array $params): bool
    {
        $response = $this->api->post('deleteChatStickerSet', $params);

        return $response->getResult();
    }
}
