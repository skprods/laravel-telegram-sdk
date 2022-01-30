<?php

namespace SKprods\Telegram\Core\History;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use SKprods\Telegram\Exceptions\TelegramException;
use SKprods\Telegram\Writers\WriterInterface;

class ChatInfo implements Arrayable, Jsonable
{
    public int $id;
    public Command $currentCommand;
    public Command $previousCommand;
    public Dialog $dialog;

    private WriterInterface $writer;

    public static function create(array $data, WriterInterface $writer): self
    {
        if (!isset($data['id'])) {
            throw new TelegramException('Некорректное значение ID чата для ChatInfo');
        }

        $chatInfo = new self();
        $chatInfo->id = $data['id'];
        $chatInfo->currentCommand = Command::create($data['currentCommand'] ?? []);
        $chatInfo->previousCommand = Command::create($data['previousCommand'] ?? []);
        $chatInfo->dialog = Dialog::create($data['dialog'] ?? []);
        $chatInfo->writer = $writer;

        return $chatInfo;
    }

    public function save()
    {
        $this->writer->setChatInfo($this);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'currentCommand' => $this->currentCommand->toArray(),
            'previousCommand' => $this->previousCommand->toArray(),
            'dialog' => $this->dialog->toArray(),
        ];
    }

    public function toJson($options = null): bool|string
    {
        return json_encode($this->toArray(), $options ?? JSON_UNESCAPED_UNICODE);
    }
}