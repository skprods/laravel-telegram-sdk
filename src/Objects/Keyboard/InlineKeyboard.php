<?php

namespace SKprods\Telegram\Objects\Keyboard;

use SKprods\Telegram\Objects\BaseObject;

class InlineKeyboard extends BaseObject
{
    protected function casts(): array
    {
        return [];
    }

    /**
     * @return InlineKeyboardButton[]
     */
    public function buttons(): array
    {
        $data = [];

        foreach ($this->properties as $keyboardButton) {
            $data[] = InlineKeyboardButton::make($keyboardButton);
        }

        return $data;
    }

    public function toArray(): array
    {
        $data = [];

        foreach ($this->properties as $keyboardButton) {
            $data[] = InlineKeyboardButton::make($keyboardButton)->toArray();
        }

        return $data;
    }
}