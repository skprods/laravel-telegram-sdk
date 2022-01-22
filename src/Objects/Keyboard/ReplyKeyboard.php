<?php

namespace SKprods\Telegram\Objects\Keyboard;

use SKprods\Telegram\Objects\BaseObject;

class ReplyKeyboard extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }

    /**
     * @return KeyboardButton[]
     */
    public function buttons(): array
    {
        $data = [];

        foreach ($this->properties as $keyboardButton) {
            $data[] = KeyboardButton::make($keyboardButton);
        }

        return $data;
    }

    public function toArray(): array
    {
        $data = [];

        foreach ($this->properties as $keyboardButton) {
            $data[] = KeyboardButton::make($keyboardButton)->toArray();
        }

        return $data;
    }
}