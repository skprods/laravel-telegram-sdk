<?php

namespace SKprods\Telegram\Writers;

use SKprods\Telegram\Core\History\ChatInfo;

interface WriterInterface
{
    public function getChatInfo(int $chatId): ChatInfo;

    public function setChatInfo(ChatInfo $chatInfo);
}