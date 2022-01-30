<?php

namespace SKprods\Telegram\Core\History;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Dialog implements Arrayable, Jsonable
{
    public const ACTIVE_STATUS = 'active';
    public const COMPLETED_STATUS = 'completed';

    /** Имя-идентификатор диалога */
    public ?string $name = null;

    /** Имя класса-обработчика диалога с namespace */
    public ?string $className = null;

    /** Статус диалога: active/completed */
    public ?string $status = null;

    /** Завершённые шаги */
    public array $completedSteps = [];

    /** Пользовательская информация */
    public array $data = [];

    public static function create(array $data): self
    {
        $dialog = new self();
        $dialog->name = $data['name'] ?? null;
        $dialog->className = $data['className'] ?? null;
        $dialog->status = $data['status'] ?? null;
        $dialog->completedSteps = $data['completedSteps'] ?? [];
        $dialog->data = $data['data'] ?? [];

        return $dialog;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'className' => $this->className,
            'status' => $this->status,
            'completedSteps' => $this->completedSteps,
            'data' => $this->data,
        ];
    }

    public function toJson($options = null): bool|string
    {
        return json_encode($this->toArray(), $options ?? JSON_UNESCAPED_UNICODE);
    }
}