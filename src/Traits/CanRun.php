<?php

namespace SKprods\Telegram\Traits;

trait CanRun
{
    protected function beforeHandle()
    {
        // переопределите метод и выполните код до обработки
    }

    abstract protected function handle();

    protected function afterHandle()
    {
        // переопределите метод и выполните код после обработки
    }
}
