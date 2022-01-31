<?php

namespace SKprods\Telegram\Core\History;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Command implements Arrayable, Jsonable
{
    /** Имя-идентификатор команды */
    public ?string $name;

    /** Паттерн команды */
    public ?string $pattern = null;

    /** Аргументы команды. Присутствуют, когда есть pattern с параметрами */
    public array $arguments = [];

    /** Если в команде используется клавиатура с callback, указывает на параметр */
    public ?int $callbackData = null;

    /** Имя класса-обработчика команды с namespace */
    public ?string $className = null;

    public static function create(array $data): self
    {
        $command = new self();
        $command->name = $data['name'] ?? null;
        $command->pattern = $data['pattern'] ?? null;
        $command->arguments = $data['arguments'] ?? [];
        $command->callbackData = $data['callbackData'] ?? null;
        $command->className = $data['className'] ?? null;

        return $command;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'pattern' => $this->pattern,
            'arguments' => $this->arguments,
            'callbackData' => $this->callbackData,
            'className' => $this->className,
        ];
    }

    public function toJson($options = null): bool|string
    {
        return json_encode($this->toArray(), $options ?? JSON_UNESCAPED_UNICODE);
    }
}