<?php

namespace SKprods\Telegram\Clients;

use SKprods\Telegram\Api\Request;
use SKprods\Telegram\Api\Response;

interface ClientInterface
{
    public function get(Request $request): Response;

    public function post(Request $request): Response;
}