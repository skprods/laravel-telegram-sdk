<?php

namespace SKprods\Telegram\Methods;

trait Passport
{
    /**
     * Используйте этот метод, если данные, предоставленные пользователем, по какой-либо причине не соответствуют
     * стандартам, требуемым вашим сервисом. Например, если дата рождения кажется неверной, отправленный документ
     * размыт, сканирование показывает признаки подделки и т.д. Укажите некоторые подробности в сообщении об ошибке,
     * чтобы убедиться, что пользователь знает, как исправить проблемы.
     *
     * $params = [
     *   'user_id'                 => '',
     *   'errors'                  => '',
     * ];
     *
     * @link https://core.telegram.org/bots/api#setpassportdataerrors
     */
    public function setPassportDataErrors(array $params): bool
    {
        return $this->api->post('setPassportDataErrors', $params)->getResult();
    }
}
