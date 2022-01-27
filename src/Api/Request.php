<?php

namespace SKprods\Telegram\Api;

class Request
{
    public const GET_METHOD = 'GET';
    public const POST_METHOD = 'POST';

    public string $method;

    public string $url;

    public array $params;

    public array $headers;

    public function __construct(string $method, string $url, array $params = [], array $headers = [])
    {
        $this->method = $method;
        $this->url = $url;
        $this->params = $params;
        $this->headers = $headers;
    }

    public function hasEmptyParams(): bool
    {
        return empty($this->params);
    }

    public function getParamsString(): string
    {
        $params = [];
        foreach ($this->params as $key => $value) {
            $params[] = "$key=$value";
        }

        return implode('&', $params);
    }

    public function hasHeader(string $key): bool
    {
        return isset($this->headers[$key]);
    }

    public function addHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }
}