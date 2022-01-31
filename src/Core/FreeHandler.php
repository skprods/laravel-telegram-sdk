<?php

namespace SKprods\Telegram\Core;

use SKprods\Telegram\Objects\Update;

abstract class FreeHandler
{
    protected Telegram $telegram;

    protected Update $update;

    public function make(Telegram $telegram, Update $update)
    {
        $this->telegram = $telegram;
        $this->update = $update;

        $this->handle();
    }

    abstract public function handle();
}