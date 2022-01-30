<?php

namespace SKprods\Telegram\Writers;

use SKprods\Telegram\Core\History\ChatInfo;

class FileWriter implements WriterInterface
{
    private string $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('/app/chatInfo.json');
    }

    private function getFile(): array
    {
        if (file_exists($this->filePath)) {
            $file = file_get_contents($this->filePath);
        } else {
            $file = null;
        }

        return $file ? json_decode($file, JSON_UNESCAPED_UNICODE) : [];
    }

    public function getChatInfo(int $chatId): ChatInfo
    {
        $file = $this->getFile();
        $data = $file[$chatId] ?? ['id' => $chatId];

        return ChatInfo::create($data, $this);
    }

    public function setChatInfo(ChatInfo $chatInfo)
    {
        $file = $this->getFile();
        $file[$chatInfo->id] = $chatInfo->toArray();
        $contents = json_encode($file, JSON_UNESCAPED_UNICODE);

        file_put_contents($this->filePath, $contents);
    }
}